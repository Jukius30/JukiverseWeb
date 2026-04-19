<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Menampilkan halaman Store dengan produk dan riwayat pembelian terbaru.
     */
    public function index()
    {
        // 1. Ambil semua produk aktif
        $products = DB::table('products')
            ->where('status', 'active')
            ->get();

        // 2. Ambil data user dari tabel emails berdasarkan UUID di session
        $userEmail = DB::table('emails')
            ->where('minecraft_uuid', session('uuid'))
            ->first();

        $recentPurchases = [];

        if ($userEmail) {
            // 3. Ambil riwayat dari tabel 'transactions' (Bukan purchase_histories)
            $recentPurchases = DB::table('transactions')
                ->where('email_id', $userEmail->id)
                ->orderBy('created_at', 'desc')
                ->take(5) 
                ->get();
        }

        return view('pages.store', [
            'products' => $products,
            'recentPurchases' => $recentPurchases
        ]);
    }

    public function show($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        if (!$product) {
            return redirect()->route('store')->with('error', 'Produk tidak ditemukan.');
        }
        return view('pages.product_detail', compact('product'));
    }
}