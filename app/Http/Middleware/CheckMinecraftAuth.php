<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMinecraftAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        // Debugging: Jika kamu ingin melihat apa yang dibaca middleware
        // \Log::info('Session di Middleware:', $request->session()->all());

        // Pastikan mengecek key yang sesuai dengan var_dump kamu tadi
        if (!$request->session()->has('logged_in') || $request->session()->get('logged_in') !== true) {
            return redirect()->route('login')->with('error', 'Sesi tidak ditemukan.');
        }

        return $next($request);
    }
}