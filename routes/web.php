<?php

use Illuminate\Support\Facades\Route;

// Controller untuk autentikasi
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\AdminLoginController;

// Controller untuk Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\KavlingController as AdminKavling;
use App\Http\Controllers\Admin\TransaksiController as AdminTransaksi;
use App\Http\Controllers\Admin\LaporanController as AdminLaporan;
use App\Http\Controllers\Admin\PelangganController as AdminPelanggan;
use App\Http\Controllers\Admin\ClusterController as AdminCluster;

// Controller untuk Pimpinan
use App\Http\Controllers\Pimpinan\DashboardController as PimpinanDashboard;
use App\Http\Controllers\Pimpinan\LaporanController as PimpinanLaporan;

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

    // Autentikasi admin
    Route::prefix('admin')->name('admin.')->group(function () {
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
    // RUTE ADMIN - Untuk administrator
    // ──────────────────────────────────────────────────────────────────────

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');

        // Manajemen pelanggan
        Route::get('/pembeli', [AdminPelanggan::class, 'index'])->name('pembeli.index');
        Route::post('/pembeli', [AdminPelanggan::class, 'store'])->name('pembeli.store');
        Route::put('/pembeli/{id}', [AdminPelanggan::class, 'update'])->name('pembeli.update');
        Route::delete('/pembeli/{id}', [AdminPelanggan::class, 'destroy'])->name('pembeli.destroy');

        // Manajemen reservasi
        Route::get('/reservasi', [AdminTransaksi::class, 'reservasi'])->name('reservasi.index');
        Route::post('/reservasi', [AdminTransaksi::class, 'storeReservasi'])->name('reservasi.store');
        Route::put('/reservasi/{id}/status', [AdminTransaksi::class, 'updateStatus'])->name('reservasi.updateStatus');

        // Manajemen kavling
        Route::get('/kavling', [AdminKavling::class, 'index'])->name('kavling.index');
        Route::post('/kavling', [AdminKavling::class, 'store'])->name('kavling.store');
        Route::put('/kavling/{id}', [AdminKavling::class, 'update'])->name('kavling.update');
        Route::delete('/kavling/{id}', [AdminKavling::class, 'destroy'])->name('kavling.destroy');

        // Manajemen cluster
        Route::get('/cluster', [AdminCluster::class, 'index'])->name('cluster.index');
        Route::post('/cluster', [AdminCluster::class, 'store'])->name('cluster.store');
        Route::put('/cluster/{id}', [AdminCluster::class, 'update'])->name('cluster.update');
        Route::delete('/cluster/{id}', [AdminCluster::class, 'destroy'])->name('cluster.destroy');

        // Manajemen pembayaran
        Route::get('/pembayaran', [AdminTransaksi::class, 'pembayaran'])->name('pembayaran.index');
        Route::put('/pembayaran/{id}/konfirmasi', [AdminTransaksi::class, 'konfirmasiPembayaran'])->name('pembayaran.konfirmasi');

        // Laporan
        Route::get('/laporan', [AdminLaporan::class, 'index'])->name('laporan.index');
        Route::get('/laporan/pdf', [AdminLaporan::class, 'exportPdf'])->name('laporan.pdf');

        // Manajemen sertifikat
        Route::get('/sertifikat', [\App\Http\Controllers\Admin\SertifikatController::class, 'index'])->name('sertifikat.index');
        Route::post('/sertifikat/{id}/upload', [\App\Http\Controllers\Admin\SertifikatController::class, 'upload'])->name('sertifikat.upload');
        Route::delete('/sertifikat/{id}', [\App\Http\Controllers\Admin\SertifikatController::class, 'destroy'])->name('sertifikat.destroy');
    });

    // ──────────────────────────────────────────────────────────────────────
    // RUTE PIMPINAN - Untuk pimpinan/manager
    // ──────────────────────────────────────────────────────────────────────

    Route::middleware('role:pimpinan')->prefix('pimpinan')->name('pimpinan.')->group(function () {
        // Dashboard
        Route::get('/', [PimpinanDashboard::class, 'index'])->name('dashboard');

        // Akses view-only ke berbagai data
        Route::get('/cluster', [AdminCluster::class, 'index'])->name('cluster.index');
        Route::get('/kavling', [AdminKavling::class, 'index'])->name('kavling.index');
        Route::get('/pembeli', [AdminPelanggan::class, 'index'])->name('pembeli.index');
        Route::get('/reservasi', [AdminTransaksi::class, 'reservasi'])->name('reservasi.index');
        Route::get('/pembayaran', [AdminTransaksi::class, 'pembayaran'])->name('pembayaran.index');

        // Laporan
        Route::get('/laporan', [PimpinanLaporan::class, 'index'])->name('laporan.index');
        Route::get('/laporan/cetak', [PimpinanLaporan::class, 'cetak'])->name('laporan.cetak');
    });

    // ──────────────────────────────────────────────────────────────────────
    // RUTE PEMBELI - Untuk pembeli/pelanggan
    // ──────────────────────────────────────────────────────────────────────

    Route::middleware('role:pembeli')->prefix('pembeli')->name('pembeli.')->group(function () {
        // Browsing dan pemilihan kavling
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

        // Browsing cluster (duplikat? mungkin disengaja)
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

