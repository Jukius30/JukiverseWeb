<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Middleware\CheckMinecraftAuth;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AdminController;

// Pastikan group 'web' membungkus middleware kustom kamu
Route::middleware(['web'])->group(function () {

    // Public Routes
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/midtrans/callback', [PurchaseController::class, 'callback'])
        ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class]);
    Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');

    // Protected Routes
    Route::middleware([\App\Http\Middleware\CheckMinecraftAuth::class])->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/store', [ProductController::class, 'index'])->name('store');
        Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
        Route::post('/purchase', [PurchaseController::class, 'store'])->name('purchase.submit');
        // Menampilkan halaman struk
        Route::post('/checkout', [PurchaseController::class, 'checkout'])->name('purchase.checkout');
        // Proses pembuatan transaksi Midtrans
        Route::post('/purchase/pay', [PurchaseController::class, 'pay'])->name('purchase.pay');


        // (Opsional) Endpoint pengecekan status server Minecraft via API
        Route::get('/server/status', function () {
            return response()->json([
                'status' => 'online',
                'server_time' => now()->toDateTimeString(),
            ]);
        });

        
    });
    Route::middleware(['admin'])->group(function () {
            Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
            Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
            Route::post('/admin/provision/retry/{id}', [AdminController::class, 'retryProvision'])->name('admin.provision.retry');
        });
});
