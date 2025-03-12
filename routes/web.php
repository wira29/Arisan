<?php

use App\Http\Controllers\Peserta\BerandaController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ApprovedPesertaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Peserta\RiwayatPembayaranController;
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
            'dashboard' => DashboardController::class,
        ]);
        Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran');
        Route::post('/pembayaran/bayar', [PembayaranController::class, 'bayar'])->name('pembayaran.bayar');

        Route::post('/approvepeserta/{id}/approve', [ApprovedPesertaController::class, 'approve'])->name('approve-peserta');
        Route::post('/tutup-arisan', [SettingController::class, 'tutupArisan'])->name('setting.tutupArisan');
        Route::get('/approvedpeserta/print/{id}', [ApprovedPesertaController::class, 'print'])->name('approvedpeserta.print');
        Route::get('/dashboard/data-peserta', [DashboardController::class, 'getDataPeserta'])->name('dashboard.dataPeserta');
    });

    // peserta
    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
    Route::get('/join', [BerandaController::class, 'join'])->name('join');
    Route::post('/joinAction', [BerandaController::class, 'joinAction'])->name('joinAction');
    Route::get('/riwayat', [RiwayatPembayaranController::class, 'index'])->name('riwayat');
});
