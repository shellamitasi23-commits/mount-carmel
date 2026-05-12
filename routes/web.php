<?php

use Illuminate\Support\Facades\Route;

// Controller untuk autentikasi
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\AdminLoginController;

// Controller untuk Pembeli
use App\Http\Controllers\Pembeli\HomeController as PembeliHome;
use App\Http\Controllers\Pembeli\ReservasiController as PembeliReservasi;
use App\Http\Controllers\Pembeli\PembayaranController as PembeliPembayaran;
use App\Http\Controllers\Pembeli\ClusterController as PembeliCluster;
use App\Http\Controllers\Pembeli\KavlingController as PembeliKavling;
use App\Http\Controllers\Pembeli\ProfilController as PembeliProfil;


// ──────────────────────────────────────────────────────────────────────────
//  PUBLIK - Dapat diakses tanpa autentikasi
// ──────────────────────────────────────────────────────────────────────────

// Halaman utama
Route::get('/', [PembeliHome::class, 'index'])->name('home');

// Browsing cluster
Route::get('/cluster', [PembeliCluster::class, 'index'])->name('cluster.index');
Route::get('/cluster/{id}', [PembeliCluster::class, 'show'])->name('cluster.show');

// Halaman kontak
Route::get('/kontak', [\App\Http\Controllers\Pembeli\KontakController::class, 'index'])->name('kontak');
Route::post('/kontak', [\App\Http\Controllers\Pembeli\KontakController::class, 'send'])->name('kontak.send');

// ──────────────────────────────────────────────────────────────────────────
//  Hanya untuk pengguna yang belum login
// ──────────────────────────────────────────────────────────────────────────

Route::middleware('guest')->group(function () {
    // Reset password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // Autentikasi pengguna
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

    // Autentikasi marketing/staf
    Route::prefix('marketing')->name('marketing.')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
    });
});

// ──────────────────────────────────────────────────────────────────────────
// RUTE TERAUTENTIKASI - Membutuhkan login pengguna
// ──────────────────────────────────────────────────────────────────────────

Route::middleware('auth')->group(function () {
    // Logout untuk semua pengguna yang terautentikasi
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    // ──────────────────────────────────────────────────────────────────────
    // RUTE MARKETING - Untuk marketing
    // ──────────────────────────────────────────────────────────────────────
    Route::middleware('role:marketing')->prefix('marketing')->name('marketing.')->group(function () {
        // Dashboard
        Route::get('/', [\App\Http\Controllers\Marketing\DashboardController::class, 'index'])->name('dashboard');

        // Manajemen pelanggan (Pembeli)
        Route::get('/pembeli', [\App\Http\Controllers\Marketing\PelangganController::class, 'index'])->name('pembeli.index');
        Route::post('/pembeli', [\App\Http\Controllers\Marketing\PelangganController::class, 'store'])->name('pembeli.store');
        Route::put('/pembeli/{id}', [\App\Http\Controllers\Marketing\PelangganController::class, 'update'])->name('pembeli.update');
        Route::delete('/pembeli/{id}', [\App\Http\Controllers\Marketing\PelangganController::class, 'destroy'])->name('pembeli.destroy');

        // Manajemen reservasi
        Route::get('/reservasi', [\App\Http\Controllers\Marketing\TransaksiController::class, 'reservasi'])->name('reservasi.index');
        Route::post('/reservasi', [\App\Http\Controllers\Marketing\TransaksiController::class, 'storeReservasi'])->name('reservasi.store');
        Route::put('/reservasi/{id}/status', [\App\Http\Controllers\Marketing\TransaksiController::class, 'updateStatus'])->name('reservasi.updateStatus');

        // Manajemen Lahan (Kavling)
        Route::get('/kavling', [\App\Http\Controllers\Marketing\KavlingController::class, 'index'])->name('kavling.index');
        Route::post('/kavling', [\App\Http\Controllers\Marketing\KavlingController::class, 'store'])->name('kavling.store');
        Route::put('/kavling/{id}', [\App\Http\Controllers\Marketing\KavlingController::class, 'update'])->name('kavling.update');
        Route::delete('/kavling/{id}', [\App\Http\Controllers\Marketing\KavlingController::class, 'destroy'])->name('kavling.destroy');

        // Manajemen cluster
        Route::get('/cluster', [\App\Http\Controllers\Marketing\ClusterController::class, 'index'])->name('cluster.index');
        Route::post('/cluster', [\App\Http\Controllers\Marketing\ClusterController::class, 'store'])->name('cluster.store');
        Route::put('/cluster/{id}', [\App\Http\Controllers\Marketing\ClusterController::class, 'update'])->name('cluster.update');
        Route::delete('/cluster/{id}', [\App\Http\Controllers\Marketing\ClusterController::class, 'destroy'])->name('cluster.destroy');

        // Manajemen pembayaran (Read-only)
        Route::get('/pembayaran', [\App\Http\Controllers\Marketing\TransaksiController::class, 'pembayaran'])->name('pembayaran.index');

        // Laporan
        Route::get('/laporan', [\App\Http\Controllers\Marketing\LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/pdf', [\App\Http\Controllers\Marketing\LaporanController::class, 'exportPdf'])->name('laporan.pdf');

        // Manajemen sertifikat
        Route::get('/sertifikat', [\App\Http\Controllers\Marketing\SertifikatController::class, 'index'])->name('sertifikat.index');
        Route::post('/sertifikat/{id}/upload', [\App\Http\Controllers\Marketing\SertifikatController::class, 'upload'])->name('sertifikat.upload');
        Route::delete('/sertifikat/{id}', [\App\Http\Controllers\Marketing\SertifikatController::class, 'destroy'])->name('sertifikat.destroy');
    });

    // ──────────────────────────────────────────────────────────────────────
    // RUTE MANAJER - Untuk manajer
    // ──────────────────────────────────────────────────────────────────────
    Route::middleware('role:manajer')->prefix('manajer')->name('manajer.')->group(function () {
        // Dashboard
        Route::get('/', [\App\Http\Controllers\Manajer\DashboardController::class, 'index'])->name('dashboard');

        // Akses view-only ke berbagai data (Mengarahkan ke Controller Marketing)
        Route::get('/cluster', [\App\Http\Controllers\Marketing\ClusterController::class, 'index'])->name('cluster.index');
        Route::get('/kavling', [\App\Http\Controllers\Marketing\KavlingController::class, 'index'])->name('kavling.index');
        Route::get('/pembeli', [\App\Http\Controllers\Marketing\PelangganController::class, 'index'])->name('pembeli.index');
        Route::get('/reservasi', [\App\Http\Controllers\Marketing\TransaksiController::class, 'reservasi'])->name('reservasi.index');
        Route::get('/pembayaran', [\App\Http\Controllers\Marketing\TransaksiController::class, 'pembayaran'])->name('pembayaran.index');

        // Laporan
        Route::get('/laporan', [\App\Http\Controllers\Manajer\LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/cetak', [\App\Http\Controllers\Manajer\LaporanController::class, 'cetak'])->name('laporan.cetak');
    });

    // ──────────────────────────────────────────────────────────────────────
    // RUTE ACCOUNTING - Untuk accounting
    // ──────────────────────────────────────────────────────────────────────
    Route::middleware('role:accounting')->prefix('accounting')->name('accounting.')->group(function () {
        // Dashboard
        Route::get('/', [\App\Http\Controllers\Accounting\DashboardController::class, 'index'])->name('dashboard');

        // Akses view-only ke data pelanggan (Pembeli)
        Route::get('/pembeli', [\App\Http\Controllers\Marketing\PelangganController::class, 'index'])->name('pembeli.index');

        // Kelola Harga
        Route::get('/harga', [\App\Http\Controllers\Accounting\HargaController::class, 'index'])->name('harga.index');
        Route::put('/harga/{id}', [\App\Http\Controllers\Accounting\HargaController::class, 'update'])->name('harga.update');

        // Kelola Pembayaran
        Route::get('/pembayaran', [\App\Http\Controllers\Accounting\TransaksiController::class, 'pembayaran'])->name('pembayaran.index');
        Route::put('/pembayaran/{id}/konfirmasi', [\App\Http\Controllers\Accounting\TransaksiController::class, 'konfirmasiPembayaran'])->name('pembayaran.konfirmasi');

        // Cetak Invoice
        Route::get('/pembayaran/invoice/{id}', [PembeliPembayaran::class, 'invoice'])->name('pembayaran.invoice');
    });

    // ──────────────────────────────────────────────────────────────────────
    // RUTE KOORDINATOR LAPANGAN - Untuk koordinator lapangan
    // ──────────────────────────────────────────────────────────────────────
    Route::middleware('role:koordinator_lapangan')->prefix('koordinator-lapangan')->name('koordinator_lapangan.')->group(function () {
        // Dashboard
        Route::get('/', [\App\Http\Controllers\KoordinatorLapangan\DashboardController::class, 'index'])->name('dashboard');

        // Kelola Cluster
        Route::get('/cluster', [\App\Http\Controllers\KoordinatorLapangan\ClusterController::class, 'index'])->name('cluster.index');
        Route::post('/cluster', [\App\Http\Controllers\KoordinatorLapangan\ClusterController::class, 'store'])->name('cluster.store');
        Route::put('/cluster/{id}', [\App\Http\Controllers\KoordinatorLapangan\ClusterController::class, 'update'])->name('cluster.update');
        Route::delete('/cluster/{id}', [\App\Http\Controllers\KoordinatorLapangan\ClusterController::class, 'destroy'])->name('cluster.destroy');

        // Kelola Lahan (Kavling)
        Route::get('/kavling', [\App\Http\Controllers\KoordinatorLapangan\KavlingController::class, 'index'])->name('kavling.index');
        Route::post('/kavling', [\App\Http\Controllers\KoordinatorLapangan\KavlingController::class, 'store'])->name('kavling.store');
        Route::put('/kavling/{id}', [\App\Http\Controllers\KoordinatorLapangan\KavlingController::class, 'update'])->name('kavling.update');
        Route::delete('/kavling/{id}', [\App\Http\Controllers\KoordinatorLapangan\KavlingController::class, 'destroy'])->name('kavling.destroy');
    });

    // ──────────────────────────────────────────────────────────────────────
    // RUTE PEMBELI - Untuk pembeli/pelanggan
    // ──────────────────────────────────────────────────────────────────────
    Route::middleware('role:pembeli')->prefix('pembeli')->name('pembeli.')->group(function () {
        // Browsing dan pemilihan Lahan (Kavling)
        Route::get('/kavling', [PembeliKavling::class, 'index'])->name('kavling.index');
        Route::get('/kavling/nomor', [PembeliKavling::class, 'nomorKavling'])->name('kavling.nomor');

        // Manajemen reservasi
        Route::get('/reservasi', [PembeliReservasi::class, 'index'])->name('reservasi.index'); // Riwayat
        Route::get('/reservasi/create', [PembeliReservasi::class, 'create'])->name('reservasi.create'); // Form
        Route::post('/reservasi', [PembeliReservasi::class, 'store'])->name('reservasi.store'); // Simpan

        // Manajemen pembayaran
        Route::get('/pembayaran', [PembeliPembayaran::class, 'index'])->name('pembayaran.index'); // Riwayat
        Route::get('/pembayaran/create', [PembeliPembayaran::class, 'create'])->name('pembayaran.create'); // Form
        Route::post('/pembayaran', [PembeliPembayaran::class, 'store'])->name('pembayaran.store'); // Simpan
        Route::get('/pembayaran/invoice/{id}', [PembeliPembayaran::class, 'invoice'])->name('pembayaran.invoice'); // Invoice

        // Browsing cluster
        Route::get('/cluster', [PembeliCluster::class, 'index'])->name('cluster.index');
    });

    // ──────────────────────────────────────────────────────────────────────
    // RUTE PROFIL - Untuk semua pengguna terautentikasi
    // ──────────────────────────────────────────────────────────────────────
    Route::prefix('profil')->name('profil.')->group(function () {
        Route::get('/', [PembeliProfil::class, 'index'])->name('index');
        Route::patch('/update', [PembeliProfil::class, 'update'])->name('update');
        Route::put('/password', [PembeliProfil::class, 'updatePassword'])->name('password');
        Route::patch('/avatar', [PembeliProfil::class, 'updateAvatar'])->name('avatar.update');
    });
});
