<?php

namespace App\Http\Controllers;

use App\Models\PlayerEmail;
use App\Models\Product;
use App\Models\Transaction;

class ProductController extends Controller
{
  public function index()
  {
    $products = Product::where('status', 'active')
      ->where('id', '!=', 99)
      ->get();

    $userEmail = PlayerEmail::where('minecraft_uuid', session('uuid'))->first();

    $recentPurchases = [];

    if ($userEmail) {
      $recentPurchases = Transaction::where('email_id', $userEmail->id)
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
    }

    return view('pages.store', [
      'products' => $products,
      'recentPurchases' => $recentPurchases,
    ]);
  }

  public function show($id)
  {
    $product = Product::find($id);

    if (!$product) {
      return redirect()->route('store')->with('error', 'Produk tidak ditemukan.');
    }

    return view('pages.product_detail', compact('product'));
  }
}