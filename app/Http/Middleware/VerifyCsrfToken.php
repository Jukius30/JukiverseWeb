<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * URL yang harus dikecualikan dari verifikasi CSRF.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Tambahkan route callback Midtrans di sini
        'midtrans/callback',
        'purchase/callback', // Sesuaikan jika kamu pakai route lain
    ];
}