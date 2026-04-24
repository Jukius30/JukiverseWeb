<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\CheckMinecraftAuth;
use App\Http\Middleware\AdminMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes - Jukiverse Store
|--------------------------------------------------------------------------
*/

// Public & Authentication Routes
Route::middleware(['web'])->group(function () {

    // Auth Player
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Auth Admin
    Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');

    // Payment Callback (Tanpa CSRF)
    Route::post('/midtrans/callback', [PurchaseController::class, 'callback'])
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

    /*
    |--------------------------------------------------------------------------
    | Player Protected Routes (Minecraft Auth)
    |--------------------------------------------------------------------------
    */
    Route::middleware([CheckMinecraftAuth::class])->group(function () {

        // Dashboard & Store
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/store', [ProductController::class, 'index'])->name('store');
        Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
        Route::get('/settings', [AuthController::class, 'showSettings'])->name('settings');
        Route::post('/settings/update-email', [AuthController::class, 'updateEmail'])->name('settings.update_email');

        // Transaction Flow
        Route::prefix('purchase')->name('purchase.')->group(function () {
            Route::post('/', [PurchaseController::class, 'store'])->name('submit');
            Route::post('/checkout', [PurchaseController::class, 'checkout'])->name('checkout');
            Route::post('/pay', [PurchaseController::class, 'pay'])->name('pay');
        });

        // Server Utility API
        Route::get('/server/status', function () {
            return response()->json([
                'status' => 'online',
                'server_time' => now()->toDateTimeString(),
            ]);
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Protected Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

        // Management Action
        Route::post('/provision/retry/{id}', [AdminController::class, 'retryProvision'])->name('provision.retry');
    });
});
