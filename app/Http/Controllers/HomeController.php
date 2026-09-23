<?php

namespace App\Http\Controllers;

use App\Models\MinecraftUser;

class HomeController extends Controller
{
  public function index()
  {
    $uuid = session('uuid');

    if (!$uuid) {
      return redirect()->route('login')->with('error', 'Sesi habis.');
    }

    session()->save();

    $remoteUser = MinecraftUser::where('uuid', $uuid)->first();

    return view('pages.home', [
      'currentCredits' => $remoteUser->credits ?? 0,
      'username' => $remoteUser->name ?? session('username'),
    ]);
  }
}