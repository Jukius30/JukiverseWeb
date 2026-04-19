<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        $uuid = session('uuid');

        if (!$uuid) {
            return redirect()->route('login')->with('error', 'Sesi habis.');
        }

        // Paksa simpan perubahan session ke database
        session()->save();

        $remoteUser = DB::connection('minecraft_remote')
            ->table('nextcredits_users')
            ->where('uuid', $uuid)
            ->first();

        return view('pages.home', [
            'currentCredits' => $remoteUser->credits ?? 0,
            'username' => $remoteUser->name ?? session('username')
        ]);
    }
}
