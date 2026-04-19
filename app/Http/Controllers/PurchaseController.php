<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class PurchaseController extends Controller
{
    /**
     * Menampilkan halaman Struk (Review) sebelum bayar
     */
    public function store(Request $request)
    {
        $type = $request->input('type');
        $uuid = session('uuid');

        if ($type === 'fixed') {
            $product = DB::table('products')->where('id', $request->product_id)->first();
            if (!$product) return back()->with('error', 'Produk tidak ditemukan.');

            $coinAmount = (int) $product->product_name;

            $data = [
                'type' => 'fixed',
                'productId' => $product->id,
                'productName' => $coinAmount . " K-Bucks",
                'amount' => $coinAmount,
                'price' => $product->price
            ];
        } else {
            $request->validate(['amount' => 'required|integer|min:100']);
            $coins = $request->input('amount');
            $data = [
                'type' => 'custom',
                'productId' => null,
                'productName' => number_format($coins) . " K-Bucks (Custom)",
                'amount' => $coins,
                'price' => $coins * 10
            ];
        }

        return view('pages.checkout', $data);
    }

    /**
     * Membuat transaksi ke Midtrans dan Redirect ke halaman pembayaran
     */
    public function pay(Request $request)
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $orderId = 'JKV-' . time() . rand(10, 99);
        $uuid = session('uuid');
        $userEmail = DB::table('emails')->where('minecraft_uuid', $uuid)->first();

        // Pastikan product_id jadi NULL jika memang tidak ada (untuk custom order)
        $productId = $request->product_id ?: null;

        // Simpan transaksi
        DB::table('transactions')->insert([
            'email_id' => $userEmail->id,
            'product_id' => $productId, // Sekarang bisa NULL tanpa error 23000
            'minecraft_uuid' => $uuid,
            'minecraft_name' => session('username'),
            'midtrans_order_id' => $orderId,
            'payment_status' => 'pending',
            'amount' => $request->price,
            'created_at' => now(),
            'updated_at' => now(),
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
            // TAMBAHKAN ATAU PASTIKAN BAGIAN INI ADA:
            'callbacks' => [
                'finish' => route('store'), // Akan kembali ke halaman Store
                'unfinish' => route('store'),
                'error' => route('store'),
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return redirect()->away("https://app.sandbox.midtrans.com/snap/v2/vtweb/" . $snapToken);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses ke Midtrans: ' . $e->getMessage());
        }
    }

    /**
     * Webhook Callback: Midtrans memanggil rute ini saat pembayaran sukses
     */
    public function callback(Request $request)
    {
        Log::info("📨 Callback masuk untuk Order: " . $request->order_id);

        // Logic Pengecekan Signature (Matikan sementara jika test via Postman)
        // $serverKey = env('MIDTRANS_SERVER_KEY');
        // $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        // if ($hashed !== $request->signature_key) return response()->json(['message' => 'Invalid Signature'], 403);

        $status = $request->transaction_status;
        $orderId = $request->order_id;

        if ($status == 'capture' || $status == 'settlement') {

            $trx = DB::table('transactions')->where('midtrans_order_id', $orderId)->first();

            if ($trx && $trx->payment_status == 'pending') {
                // 1. Update status di database kita
                DB::table('transactions')->where('midtrans_order_id', $orderId)->update([
                    'payment_status' => 'success',
                    'updated_at' => now()
                ]);
                Log::info("✅ Status Database Updated: Success ($orderId)");

                // 2. Tentukan jumlah koin (asumsi harga 1000 = 100 koin)
                $coinAmount = (int) ($trx->amount / 10);

                // 3. Eksekusi perintah ke Pterodactyl
                $this->sendToPterodactyl($trx->minecraft_uuid, $coinAmount, $orderId);
            } else {
                Log::warning("⚠️ Order $orderId sudah success atau tidak ditemukan.");
            }
        }

        return response()->json(['message' => 'Webhook received']);
    }

    /**
     * Fungsi internal untuk menembak API Pterodactyl
     */
    private function sendToPterodactyl($uuid, $amount, $orderId)
    {
        $trx = DB::table('transactions')->where('midtrans_order_id', $orderId)->first();

        if ($trx && !empty($trx->minecraft_name)) {
            $name = $trx->minecraft_name;
            $command = "nextcredit give $name $amount";

            try {
                // Kirim command ke Pterodactyl Panel
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . env('PTERO_API_KEY'),
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])->post(env('PTERO_PANEL_URL') . "/api/client/servers/" . env('PTERO_SERVER_UUID') . "/command", [
                    'command' => $command
                ]);

                $isSuccess = $response->successful();

                // INSERT KE PROVISION_LOGS
                DB::table('provision_logs')->insert([
                    'transaction_id'   => $trx->id, // Mengambil ID dari tabel transactions
                    'execution_status' => $isSuccess ? 'success' : 'failed',
                    'executed_at'      => now(),
                    'message_log'      => $isSuccess ? "Command executed: $command" : "Ptero Error: " . $response->body(),
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);

                if ($isSuccess) {
                    Log::info("✅ Provisioning Success for $name");
                } else {
                    Log::error("❌ Provisioning Failed for $orderId");
                }
            } catch (\Exception $e) {
                // Log jika server Pterodactyl mati atau koneksi putus
                DB::table('provision_logs')->insert([
                    'transaction_id'   => $trx->id,
                    'execution_status' => 'error',
                    'executed_at'      => now(),
                    'message_log'      => 'System Exception: ' . $e->getMessage(),
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
                Log::error("⚠️ Critical Provisioning Error: " . $e->getMessage());
            }
        }
    }
}
