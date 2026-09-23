<?php

namespace App\Http\Controllers;

use App\Models\PlayerEmail;
use App\Models\Product;
use App\Models\ProvisionLog;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class PurchaseController extends Controller
{
  public function store(Request $request)
  {
    $type = $request->input('type');

    if ($type === 'fixed') {
      $product = Product::find($request->product_id);

      if (!$product) {
        return back()->with('error', 'Produk tidak ditemukan.');
      }

      $coinAmount = (int) $product->product_name;

      $data = [
        'type' => 'fixed',
        'productId' => $product->id,
        'productName' => $coinAmount . " K-Bucks",
        'amount' => $coinAmount,
        'price' => $product->price,
      ];
    } else {
      $request->validate([
        'amount' => 'required|integer|min:100',
      ]);

      $coins = $request->input('amount');

      $data = [
        'type' => 'custom',
        'productId' => null,
        'productName' => number_format($coins) . " K-Bucks (Custom)",
        'amount' => $coins,
        'price' => $coins * 10,
      ];
    }

    return view('pages.checkout', $data);
  }

  public function pay(Request $request)
  {
    Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    Config::$isProduction = false;
    Config::$isSanitized = true;
    Config::$is3ds = true;

    $orderId = 'JKV-' . time() . rand(10, 99);
    $uuid = session('uuid');

    $userEmail = PlayerEmail::where('minecraft_uuid', $uuid)->first();

    if (!$userEmail) {
      return redirect()->route('store')->with('error', 'Data email player tidak ditemukan.');
    }

    $productId = $request->product_id ?: 99;

    Transaction::create([
      'email_id' => $userEmail->id,
      'product_id' => $productId,
      'minecraft_uuid' => $uuid,
      'minecraft_name' => session('username'),
      'midtrans_order_id' => $orderId,
      'payment_status' => 'pending',
      'amount' => $request->price,
    ]);

    $params = [
      'transaction_details' => [
        'order_id' => $orderId,
        'gross_amount' => (int) $request->price,
      ],
      'customer_details' => [
        'first_name' => session('username'),
        'email' => session('email'),
      ],
      'callbacks' => [
        'finish' => route('store'),
        'unfinish' => route('store'),
        'error' => route('store'),
      ],
    ];

    try {
      $snapToken = Snap::getSnapToken($params);

      return redirect()->away("https://app.sandbox.midtrans.com/snap/v2/vtweb/" . $snapToken);
    } catch (\Exception $exception) {
      return back()->with('error', 'Gagal memproses ke Midtrans: ' . $exception->getMessage());
    }
  }

  public function callback(Request $request)
  {
    Log::info("📨 Callback masuk untuk Order: " . $request->order_id);

    $status = $request->transaction_status;
    $orderId = $request->order_id;

    if ($status == 'capture' || $status == 'settlement') {
      $transaction = Transaction::where('midtrans_order_id', $orderId)->first();

      if ($transaction && $transaction->payment_status == 'pending') {
        $transaction->update([
          'payment_status' => 'success',
        ]);

        Log::info("✅ Status Database Updated: Success ($orderId)");

        $coinAmount = (int) ($transaction->amount / 10);

        $this->sendToPterodactyl($transaction->minecraft_uuid, $coinAmount, $orderId);
      } else {
        Log::warning("⚠️ Order $orderId sudah success atau tidak ditemukan.");
      }
    }

    return response()->json(['message' => 'Webhook received']);
  }

  private function sendToPterodactyl($uuid, $amount, $orderId)
  {
    $transaction = Transaction::where('midtrans_order_id', $orderId)->first();

    if (!$transaction || empty($transaction->minecraft_name)) {
      return;
    }

    $name = $transaction->minecraft_name;
    $command = "nextcredit give $name $amount";

    try {
      $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . env('PTERO_API_KEY'),
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
      ])->post(env('PTERO_PANEL_URL') . "/api/client/servers/" . env('PTERO_SERVER_UUID') . "/command", [
        'command' => $command,
      ]);

      $isSuccess = $response->successful();

      ProvisionLog::create([
        'transaction_id' => $transaction->id,
        'execution_status' => $isSuccess ? 'success' : 'failed',
        'executed_at' => now(),
        'message_log' => $isSuccess
          ? "Command executed: $command"
          : "Ptero Error: " . $response->body(),
      ]);

      if ($isSuccess) {
        Log::info("✅ Provisioning Success for $name");
      } else {
        Log::error("❌ Provisioning Failed for $orderId");
      }
    } catch (\Exception $exception) {
      ProvisionLog::create([
        'transaction_id' => $transaction->id,
        'execution_status' => 'error',
        'executed_at' => now(),
        'message_log' => 'System Exception: ' . $exception->getMessage(),
      ]);

      Log::error("⚠️ Critical Provisioning Error: " . $exception->getMessage());
    }
  }
}