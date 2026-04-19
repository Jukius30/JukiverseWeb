<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    // Halaman Login Admin
    public function showLogin()
    {
        return view('admin.login');
    }

    // Proses Login Admin
    public function login(Request $request)
    {
        $admin = DB::table('admins')->where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            session(['admin_logged_in' => true, 'admin_id' => $admin->id, 'admin_name' => $admin->display_name]);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Username atau Password salah!');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        // Query untuk Transaksi
        $transactionsQuery = DB::table('transactions')
            ->leftJoin('emails', 'transactions.email_id', '=', 'emails.id')
            ->select('transactions.*', 'emails.email_address')
            ->orderBy('transactions.created_at', 'desc');

        // Query untuk Provision Logs
        $provisionLogsQuery = DB::table('provision_logs')
            ->join('transactions', 'provision_logs.transaction_id', '=', 'transactions.id')
            ->select('provision_logs.*', 'transactions.midtrans_order_id', 'transactions.minecraft_name')
            ->orderBy('provision_logs.created_at', 'desc');

        // Jika ada input search, filter berdasarkan Order ID
        if ($search) {
            $transactionsQuery->where('transactions.midtrans_order_id', 'LIKE', "%{$search}%");
            $provisionLogsQuery->where('transactions.midtrans_order_id', 'LIKE', "%{$search}%");
        }

        $transactions = $transactionsQuery->get();
        $provisionLogs = $provisionLogsQuery->get();

        return view('admin.dashboard', compact('transactions', 'provisionLogs', 'search'));
    }

    public function retryProvision($id)
    {
        // 1. Ambil data log
        $log = DB::table('provision_logs')
            ->join('transactions', 'provision_logs.transaction_id', '=', 'transactions.id')
            ->select('provision_logs.*', 'transactions.amount', 'transactions.minecraft_name', 'transactions.midtrans_order_id')
            ->where('provision_logs.id', $id)
            ->first();

        if (!$log) return back()->with('error', 'Log tidak ditemukan.');

        // 2. Siapkan Command
        $command = "nextcredit give {$log->minecraft_name} {$log->amount}";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('PTERO_API_KEY'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post(env('PTERO_PANEL_URL') . "/api/client/servers/" . env('PTERO_SERVER_UUID') . "/command", [
                'command' => $command
            ]);

            if ($response->successful()) {
                // 3. Update status log menjadi success
                DB::table('provision_logs')->where('id', $id)->update([
                    'execution_status' => 'success',
                    'message_log' => "Retried successfully: " . $command,
                    'executed_at' => now(),
                    'updated_at' => now()
                ]);
                return back()->with('success', 'Koin berhasil dikirim ulang ke ' . $log->minecraft_name);
            } else {
                // Update pesan error terbaru jika masih gagal
                DB::table('provision_logs')->where('id', $id)->update([
                    'message_log' => "Retry failed: " . $response->body(),
                    'updated_at' => now()
                ]);
                return back()->with('error', 'Gagal lagi: ' . $response->body());
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Koneksi ke Pterodactyl bermasalah.');
        }
    }

    public function logout(Request $request)
    {
        session()->forget(['admin_logged_in', 'admin_id', 'admin_name']);
        return redirect()->route('admin.login')->with('success', 'Logged out safely.');
    }
}
