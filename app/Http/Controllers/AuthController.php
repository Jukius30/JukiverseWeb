<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('logged_in')) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        $name = trim($request->input('name'));
        $inputEmail = strtolower(trim($request->input('email')));

        try {
            // 1. Ambil data dari DATABASE REMOTE (Minecraft Server)
            $user = DB::connection('minecraft_remote')
                ->table('nextcredits_users')
                ->whereRaw('LOWER(name) = ?', [strtolower($name)])
                ->first();

            if (!$user) {
                return back()->with('error', 'Username Minecraft tidak terdaftar!');
            }

            // 2. LOGIKA LOCK-IN EMAIL & UPDATE DATA (Database Lokal Jukiverse)
            $existingRecord = DB::table('emails')
                ->where('minecraft_uuid', $user->uuid)
                ->first();

            if ($existingRecord) {
                // Jika sudah ada, cek apakah emailnya cocok
                if (strtolower($existingRecord->email_address) !== $inputEmail) {
                    return back()->with('error', 'Akun ini sudah terikat dengan email lain!');
                }

                // UPDATE: Selalu update nama & timestamp setiap login (untuk handle ganti nama player)
                DB::table('emails')
                    ->where('minecraft_uuid', $user->uuid)
                    ->update([
                        'minecraft_name' => $user->name, // Memastikan kolom minecraft_name terisi
                        'updated_at' => now()
                    ]);

            } else {
                // INSERT: Masukkan data baru termasuk minecraft_name agar tidak error SQL
                DB::table('emails')->insert([
                    'minecraft_uuid' => $user->uuid,
                    'minecraft_name' => $user->name, // Data nama dari database Minecraft
                    'email_address'  => $inputEmail,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }

            // 4. Set Session
            session([
                'logged_in' => true,
                'uuid'      => $user->uuid,
                'username'  => $user->name,
                'email'     => $inputEmail,
            ]);

            // 5. Paksa simpan session
            $request->session()->save(); 

            return redirect()->route('home')->with('success', 'Halo ' . $user->name . ', berhasil login!');

        } catch (\Exception $e) {
            Log::error("Login Error: " . $e->getMessage());
            // Menampilkan pesan error lebih detail untuk debugging jika butuh
            return back()->with('error', 'Terjadi kesalahan pada sistem database.');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }
}