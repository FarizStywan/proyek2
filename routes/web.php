<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KamarController;
use App\Http\Controllers\Admin\VerifikasiPembayaranController;
use App\Http\Controllers\Admin\PemasukanPengeluaranController;
use App\Http\Controllers\Admin\PenyewaController;
use App\Http\Controllers\Admin\PengaduanController;

use App\Http\Controllers\Penyewa\PenyewaDashboardController;
use App\Http\Controllers\Penyewa\PembayaranController;
use App\Http\Controllers\Penyewa\PengaduanPenyewaController;
use App\Http\Controllers\Penyewa\ProfilPenyewaController;
use App\Http\Controllers\MidtransCallbackController;

// ===== PILIH LOGIN =====
Route::get('/pilih-login', function () {
    return view('auth.pilih-login');
})->name('pilih-login');


// ===== ADMIN LOGIN & REGISTER =====
Route::prefix('admin')->group(function () {
    // Login Admin
    Route::get('/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'adminLogin'])->name('admin.login.submit');

    // Logout Admin (tanpa middleware agar bisa logout saat sesi expired)
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    // Middleware untuk admin setelah login
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::get('/kamar', [KamarController::class, 'index'])->name('admin.kamar.index');
        Route::post('/kamar', [KamarController::class, 'store'])->name('admin.kamar.store');
        Route::get('/kamar/{id}/edit', [KamarController::class, 'edit'])->name('admin.kamar.edit');
        Route::put('/kamar/{id}', [KamarController::class, 'update'])->name('admin.kamar.update');
        Route::delete('/kamar/{id}', [KamarController::class, 'destroy'])->name('admin.kamar.destroy');

        // Verifikasi pembayaran
        Route::get('/verifikasi-pembayaran', [VerifikasiPembayaranController::class, 'index'])->name('admin.verifikasi.index');
        Route::post('/verifikasi-pembayaran/{id}', [VerifikasiPembayaranController::class, 'verifikasi'])->name('admin.verifikasi.proses');

        // Pemasukan dan pengeluaran
        Route::get('/pemasukan-pengeluaran', [PemasukanPengeluaranController::class, 'index'])->name('admin.keuangan.index');
        Route::post('/pemasukan-pengeluaran/tambah', [PemasukanPengeluaranController::class, 'store'])->name('admin.keuangan.store');

        // Data penyewa
        Route::get('/penyewa', [PenyewaController::class, 'index'])->name('admin.penyewa.index');
        Route::get('/penyewa/edit/{id}', [PenyewaController::class, 'edit'])->name('admin.penyewa.edit');
        Route::put('/penyewa/update/{id}', [PenyewaController::class, 'update'])->name('admin.penyewa.update');
        Route::delete('/penyewa/delete/{id}', [PenyewaController::class, 'destroy'])->name('admin.penyewa.destroy');

        // Pengaduan & pelaporan admin
        Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('auth.admin.pengaduan.index');
        Route::get('/pengaduan/{id}', [PengaduanController::class, 'show'])->name('admin.pengaduan.show');
        Route::patch('/pengaduan/{id}', [PengaduanController::class, 'updateStatus'])->name('admin.pengaduan.updateStatus');
    });
});


// Route default untuk login agar tidak error jika ada route('login')
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');


// ===== PENYEWA LOGIN & REGISTER =====
Route::prefix('penyewa')->group(function () {
    Route::get('/login', [AuthController::class, 'showPenyewaLoginForm'])->name('penyewa.login');
    Route::post('/login', [AuthController::class, 'penyewaLogin'])->name('penyewa.login.submit');

    Route::get('/register', [AuthController::class, 'showPenyewaRegisterForm'])->name('penyewa.register');
    Route::post('/register', [AuthController::class, 'penyewaRegister'])->name('penyewa.register.submit');

    Route::post('/logout', [AuthController::class, 'logout'])->name('penyewa.logout');

    Route::middleware(['auth:web'])->group(function () {
        Route::get('/dashboard', [PenyewaDashboardController::class, 'index'])->name('penyewa.dashboard');

        // Pembayaran
        Route::get('/bayar', [PembayaranController::class, 'showForm'])->name('auth.penyewa.bayar');
        Route::post('/bayar', [PembayaranController::class, 'processPayment'])->name('penyewa.bayar.process');
        Route::get('/histori', [PembayaranController::class, 'histori'])->name('auth.penyewa.histori');
        Route::get('/status-pembayaran', [PembayaranController::class, 'status'])->name('penyewa.status');


        // Pengaduan penyewa
        Route::get('/pengaduan', [PengaduanPenyewaController::class, 'index'])->name('auth.penyewa.pengaduan.index');
        Route::get('/pengaduan/create', [PengaduanPenyewaController::class, 'create'])->name('penyewa.pengaduan.create');
        Route::post('/pengaduan', [PengaduanPenyewaController::class, 'store'])->name('auth.penyewa.pengaduan.store');
        Route::get('/pengaduan/{id}', [PengaduanPenyewaController::class, 'show'])->name('auth.penyewa.pengaduan.show');
        Route::get('/pengaduan/{id}/edit', [PengaduanPenyewaController::class, 'edit'])->name('penyewa.pengaduan.edit');
        Route::put('/pengaduan/{id}', [PengaduanPenyewaController::class, 'update'])->name('penyewa.pengaduan.update');
        Route::delete('/pengaduan/{id}', [PengaduanPenyewaController::class, 'destroy'])->name('penyewa.pengaduan.destroy');

        // Profil penyewa
        Route::get('/profil', [ProfilPenyewaController::class, 'index'])->name('auth.penyewa.profil.index');
        Route::get('/profil/edit', [ProfilPenyewaController::class, 'edit'])->name('auth.penyewa.profil.edit');
        Route::put('/profil', [ProfilPenyewaController::class, 'update'])->name('penyewa.profil.update');
    });
});


// MIDTRANS CALLBACK - hanya 1 route untuk callback
// Route::post('/midtrans/callback', [\App\Http\Controllers\Penyewa\PembayaranController::class, 'handleCallback'])
//     ->name('midtrans.callback')
//     ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]); // Penting agar callback tidak error CSRF


Route::post('/midtrans/callback', [MidtransController::class, 'callback']);

