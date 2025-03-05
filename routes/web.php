<?php

use App\Http\Controllers\Peserta\BerandaController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ApprovedPesertaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    // admin 
    Route::prefix('admin')->group(function () {
        Route::resources([
            'produk' => ProdukController::class,
            'setting' => SettingController::class,
            'category' => CategoryController::class,
            'approvedpeserta' => ApprovedPesertaController::class,
        ]);
        Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran');

        Route::post('/approvepeserta/{id}/approve', [ApprovedPesertaController::class, 'approve'])->name('approve-peserta');
    });

    // peserta
    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
    Route::get('/join', [BerandaController::class, 'join'])->name('join');
    Route::post('/joinAction', [BerandaController::class, 'joinAction'])->name('joinAction');
});
