<?php

namespace App\Http\Controllers;

use App\Models\MinecraftUser;
use App\Models\PlayerEmail;
use Illuminate\Http\Request;
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
      $user = MinecraftUser::whereRaw('LOWER(name) = ?', [strtolower($name)])->first();

      if (!$user) {
        return back()->with('error', 'Username Minecraft tidak terdaftar!');
      }

      $existingRecord = PlayerEmail::where('minecraft_uuid', $user->uuid)->first();

      if ($existingRecord) {
        if (strtolower($existingRecord->email_address) !== $inputEmail) {
          return back()->with('error', 'Akun ini sudah terikat dengan email lain!');
        }

        $existingRecord->update([
          'minecraft_name' => $user->name,
        ]);
      } else {
        PlayerEmail::create([
          'minecraft_uuid' => $user->uuid,
          'minecraft_name' => $user->name,
          'email_address' => $inputEmail,
        ]);
      }

      session([
        'logged_in' => true,
        'uuid' => $user->uuid,
        'username' => $user->name,
        'email' => $inputEmail,
      ]);

      $request->session()->save();

      return redirect()->route('home')->with('success', 'Halo ' . $user->name . ', berhasil login!');
    } catch (\Exception $exception) {
      Log::error("Login Error: " . $exception->getMessage());

      return back()->with('error', 'Terjadi kesalahan pada sistem database.');
    }
  }

  public function showSettings()
  {
    $player = PlayerEmail::where('minecraft_uuid', session('uuid'))->first();

    return view('pages.settings', compact('player'));
  }

  public function updateEmail(Request $request)
  {
    $request->validate([
      'email' => 'required|email|max:255',
    ]);

    $updated = PlayerEmail::where('minecraft_uuid', session('uuid'))->update([
      'email_address' => $request->email,
      'updated_at' => now(),
    ]);

    if ($updated) {
      session(['email' => $request->email]);

      return back()->with('success', 'Email berhasil diperbarui!');
    }

    return back()->with('error', 'Tidak ada perubahan atau data tidak ditemukan.');
  }

  public function logout(Request $request)
  {
    $request->session()->flush();

    return redirect()->route('login');
  }
}