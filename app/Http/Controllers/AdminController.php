<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\ProvisionLog;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
  public function showLogin()
  {
    return view('admin.login');
  }

  public function login(Request $request)
  {
    $admin = Admin::where('username', $request->username)->first();

    if ($admin && Hash::check($request->password, $admin->password)) {
      session([
        'admin_logged_in' => true,
        'admin_id' => $admin->id,
        'admin_name' => $admin->display_name,
      ]);

      return redirect()->route('admin.dashboard');
    }

    return back()->with('error', 'Username atau Password salah!');
  }

  public function index(Request $request)
  {
    $search = $request->input('search');

    $transactionsQuery = Transaction::query()
      ->leftJoin('emails', 'transactions.email_id', '=', 'emails.id')
      ->select('transactions.*', 'emails.email_address')
      ->orderBy('transactions.created_at', 'desc');

    $provisionLogsQuery = ProvisionLog::query()
      ->join('transactions', 'provision_logs.transaction_id', '=', 'transactions.id')
      ->select(
        'provision_logs.*',
        'transactions.midtrans_order_id',
        'transactions.minecraft_name',
        'transactions.minecraft_uuid'
      )
      ->orderBy('provision_logs.created_at', 'desc');

    if ($search) {
      $transactionsQuery->where(function ($query) use ($search) {
        $query->where('transactions.midtrans_order_id', 'LIKE', "%{$search}%")
          ->orWhere('transactions.minecraft_name', 'LIKE', "%{$search}%");
      });

      $provisionLogsQuery->where(function ($query) use ($search) {
        $query->where('transactions.midtrans_order_id', 'LIKE', "%{$search}%")
          ->orWhere('transactions.minecraft_name', 'LIKE', "%{$search}%");
      });
    }

    $transactions = $transactionsQuery->get();
    $provisionLogs = $provisionLogsQuery->get();

    return view('admin.dashboard', compact('transactions', 'provisionLogs', 'search'));
  }

  public function retryProvision($id)
  {
    $log = ProvisionLog::query()
      ->join('transactions', 'provision_logs.transaction_id', '=', 'transactions.id')
      ->select(
        'provision_logs.*',
        'transactions.amount',
        'transactions.minecraft_name',
        'transactions.midtrans_order_id'
      )
      ->where('provision_logs.id', $id)
      ->first();

    if (!$log) {
      return back()->with('error', 'Log tidak ditemukan.');
    }

    if (empty($log->minecraft_name)) {
      return back()->with('error', 'Nama player kosong, tidak bisa mengirim koin.');
    }

    $coinAmount = (int) ($log->amount / 10);
    $command = "nextcredit give {$log->minecraft_name} {$coinAmount}";

    try {
      $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . env('PTERO_API_KEY'),
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
      ])->post(env('PTERO_PANEL_URL') . "/api/client/servers/" . env('PTERO_SERVER_UUID') . "/command", [
        'command' => $command,
      ]);

      if ($response->successful()) {
        ProvisionLog::where('id', $id)->update([
          'execution_status' => 'success',
          'message_log' => "Retried successfully: " . $command,
          'executed_at' => now(),
          'updated_at' => now(),
        ]);

        return back()->with('success', 'Koin berhasil dikirim ulang ke ' . $log->minecraft_name);
      }

      ProvisionLog::where('id', $id)->update([
        'message_log' => "Retry failed: " . $response->body(),
        'updated_at' => now(),
      ]);

      return back()->with('error', 'Gagal mengirim koin: ' . $response->body());
    } catch (\Exception $exception) {
      return back()->with('error', 'Koneksi ke Pterodactyl bermasalah: ' . $exception->getMessage());
    }
  }

  public function logout(Request $request)
  {
    session()->forget(['admin_logged_in', 'admin_id', 'admin_name']);

    return redirect()->route('admin.login')->with('success', 'Berhasil logout.');
  }
}