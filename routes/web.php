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
use App\Http\Controllers\Penyewa\MidtransController;
use App\Http\Controllers\Penyewa\PengaduanPenyewaController;
use App\Http\Controllers\Penyewa\ProfilPenyewaController;

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
    });
});

// ✅ Route Default untuk Login, agar Laravel tidak error saat mencari `route('login')`
Route::get('/login', function () {
    return redirect()->route('admin.login'); // Arahkan ke login admin
})->name('login');


    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/admin/kamar', [KamarController::class, 'index'])->name('admin.kamar.index');
        Route::post('/admin/kamar', [KamarController::class, 'store'])->name('admin.kamar.store');
        Route::get('/admin/kamar/{id}/edit', [KamarController::class, 'edit'])->name('admin.kamar.edit');
        Route::put('/admin/kamar/{id}', [KamarController::class, 'update'])->name('admin.kamar.update');
        Route::delete('/admin/kamar/{id}', [KamarController::class, 'destroy'])->name('admin.kamar.destroy');
    });


// ===== PENYEWA LOGIN & REGISTER =====
Route::prefix('penyewa')->group(function () {
    Route::get('/login', [AuthController::class, 'showPenyewaLoginForm'])->name('penyewa.login');
    Route::post('/login', [AuthController::class, 'penyewaLogin'])->name('penyewa.login.submit');

    // Register Penyewa
    Route::get('/register', [AuthController::class, 'showPenyewaRegisterForm'])->name('penyewa.register');
    Route::post('/register', [AuthController::class, 'penyewaRegister'])->name('penyewa.register.submit');

    // Logout Penyewa
    Route::post('/logout', [AuthController::class, 'logout'])->name('penyewa.logout');

    // Dashboard Penyewa
    Route::middleware(['auth:web'])->group(function () {
        Route::get('/dashboard', [PenyewaDashboardController::class, 'index'])->name('penyewa.dashboard');
    });
});


// bayar sewa //
Route::middleware(['auth:web'])->group(function () {
    Route::get('/penyewa/bayar', [PembayaranController::class, 'showForm'])->name('auth.penyewa.bayar');
    Route::post('/penyewa/bayar', [PembayaranController::class, 'processPayment'])->name('penyewa.bayar.process');
});

// pengaduan //
// pengaduan oleh penyewa
Route::middleware(['auth:web'])->group(function () {
    // Index Pengaduan
    Route::get('/penyewa/pengaduan', [App\Http\Controllers\Penyewa\PengaduanPenyewaController::class, 'index'])->name('auth.penyewa.pengaduan.index');
    
    // Create Pengaduan
    Route::get('/penyewa/pengaduan/create', [App\Http\Controllers\Penyewa\PengaduanPenyewaController::class, 'create'])->name('penyewa.pengaduan.create');
    Route::post('/penyewa/pengaduan', [App\Http\Controllers\Penyewa\PengaduanPenyewaController::class, 'store'])->name('auth.penyewa.pengaduan.store');
    
    // Show Pengaduan
    Route::get('/penyewa/pengaduan/{id}', [App\Http\Controllers\Penyewa\PengaduanPenyewaController::class, 'show'])->name('auth.penyewa.pengaduan.show');
    
    // Edit Pengaduan
    Route::get('/penyewa/pengaduan/{id}/edit', [App\Http\Controllers\Penyewa\PengaduanPenyewaController::class, 'edit'])->name('penyewa.pengaduan.edit');
    Route::put('/penyewa/pengaduan/{id}', [App\Http\Controllers\Penyewa\PengaduanPenyewaController::class, 'update'])->name('penyewa.pengaduan.update');
    
    // Destroy Pengaduan
    Route::delete('/penyewa/pengaduan/{id}', [App\Http\Controllers\Penyewa\PengaduanPenyewaController::class, 'destroy'])->name('penyewa.pengaduan.destroy');
});

Route::middleware(['auth:web'])->group(function () {
    // Route untuk menampilkan profil
    Route::get('/penyewa/profil', [App\Http\Controllers\Penyewa\ProfilPenyewaController::class, 'index'])->name('auth.penyewa.profil.index');
    
    // Route untuk mengedit profil
    Route::get('/penyewa/profil/edit', [App\Http\Controllers\Penyewa\ProfilPenyewaController::class, 'edit'])->name('auth.penyewa.profil.edit');
    
    // Route untuk memperbarui profil
    Route::put('/penyewa/profil', [App\Http\Controllers\Penyewa\ProfilPenyewaController::class, 'update'])->name('penyewa.profil.update');
});




//verifikasi yaww admin
Route::get('/admin/verifikasi-pembayaran', [VerifikasiPembayaranController::class, 'index'])->name('admin.verifikasi.index');
Route::post('/admin/verifikasi-pembayaran/{id}', [VerifikasiPembayaranController::class, 'verifikasi'])->name('admin.verifikasi.proses');

//pemasukan pengeluaran admin
Route::get('/admin/pemasukan-pengeluaran', [PemasukanPengeluaranController::class, 'index'])->name('admin.keuangan.index');
Route::post('/admin/pemasukan-pengeluaran/tambah', [PemasukanPengeluaranController::class, 'store'])->name('admin.keuangan.store');

//data penyewa admin
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/penyewa', [PenyewaController::class, 'index'])->name('admin.penyewa.index');
    Route::get('/admin/penyewa/edit/{id}', [PenyewaController::class, 'edit'])->name('admin.penyewa.edit');
    Route::put('/admin/penyewa/update/{id}', [PenyewaController::class, 'update'])->name('admin.penyewa.update');
    Route::delete('/admin/penyewa/delete/{id}', [PenyewaController::class, 'destroy'])->name('admin.penyewa.destroy');
});

//pengaduan & pelaporan
Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('auth.admin.pengaduan.index');
    Route::get('/pengaduan/{id}', [PengaduanController::class, 'show'])->name('admin.pengaduan.show');
    Route::patch('/pengaduan/{id}', [PengaduanController::class, 'updateStatus'])->name('admin.pengaduan.updateStatus');
});




