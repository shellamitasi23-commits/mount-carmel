<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\AdminLoginController;

//ADMIN
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\KavlingController as AdminKavling;
use App\Http\Controllers\Admin\TransaksiController as AdminTransaksi; // Atau Pembayaran
use App\Http\Controllers\Admin\LaporanController as AdminLaporan;
use App\Http\Controllers\Admin\PelangganController as AdminPelanggan;
use App\Http\Controllers\Admin\ClusterController as AdminCluster;
use App\Http\Controllers\Admin\HargaController as AdminHarga;

// Pimpinan
use App\Http\Controllers\Pimpinan\DashboardController as PimpinanDashboard;
use App\Http\Controllers\Pimpinan\LaporanController as PimpinanLaporan;

// Pembeli
use App\Http\Controllers\Pembeli\HomeController as PembeliHome;
use App\Http\Controllers\Pembeli\ReservasiController as PembeliReservasi;
use App\Http\Controllers\Pembeli\PembayaranController as PembeliPembayaran;
use App\Http\Controllers\Pembeli\ClusterController as PembeliCluster;
use App\Http\Controllers\Pembeli\KavlingController as PembeliKavling;
use App\Http\Controllers\Pembeli\ProfilController as PembeliProfil;



// 1. PUBLIC ROUTES (Landing Page)
Route::get('/', function () {
    // Misalnya kamu ingin mengirimkan nomor tertentu
    $nomor = 1; // Atau dari database: $nomor = Kavling::count();

    return view('pembeli.home', compact('nomor'));
})->name('home');

Route::get('/cluster', [App\Http\Controllers\Pembeli\ClusterController::class, 'index'])->name('cluster.index');

// 2. GUEST ROUTES (Belum Login)

Route::middleware('guest')->group(function () {

    // -- Area Pembeli (Lupa Password & Register) --
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // 1. Rute GET untuk MENAMPILKAN form (Arahkan ke fungsi 'index')
    Route::get('/login', [LoginController::class, 'index'])->name('login');

    // 2. Rute POST untuk MEMPROSES login (Arahkan ke fungsi 'login')
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

    // 3. Rute POST untuk LOGOUT (Arahkan ke fungsi 'logout')
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
//Register
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');


// Area Login Khusus Admin / Pimpinan 
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
    });

});



// 3. AUTH ROUTES (Sudah Login)

Route::middleware('auth')->group(function () {

    // Global Logout
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

    // =========================================================
    // A. AREA ADMIN (Akses Penuh CRUD)
    // =========================================================
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');

        // --- CRUD DATA PEMBELI / PELANGGAN ---
      Route::get('/pembeli', [AdminPelanggan::class, 'index'])->name('pembeli.index');
    Route::post('/pembeli', [AdminPelanggan::class, 'store'])->name('pembeli.store');
    Route::put('/pembeli/{id}', [AdminPelanggan::class, 'update'])->name('pembeli.update');
    Route::delete('/pembeli/{id}', [AdminPelanggan::class, 'destroy'])->name('pembeli.destroy');

        //CRUD RESERVASI
        Route::get('/reservasi', [AdminTransaksi::class, 'reservasi'])->name('reservasi.index');
        Route::post('/reservasi', [AdminTransaksi::class, 'storeReservasi'])->name('reservasi.store');
        Route::put('/reservasi/{id}/status', [AdminTransaksi::class, 'updateStatus'])->name('reservasi.updateStatus');
        // CRUD Data Kavling
        Route::get('/kavling', [AdminKavling::class, 'index'])->name('kavling.index');
        Route::post('/kavling', [AdminKavling::class, 'store'])->name('kavling.store');
        Route::put('/kavling/{id}', [AdminKavling::class, 'update'])->name('kavling.update');
        Route::delete('/kavling/{id}', [AdminKavling::class, 'destroy'])->name('kavling.destroy');
        // CRUD Data Cluster
        Route::get('/cluster', [AdminCluster::class, 'index'])->name('cluster.index');
        Route::post('/cluster', [AdminCluster::class, 'store'])->name('cluster.store');
        Route::put('/cluster/{id}', [AdminCluster::class, 'update'])->name('cluster.update');
        Route::delete('/cluster/{id}', [AdminCluster::class, 'destroy'])->name('cluster.destroy');

        Route::get('/pembayaran', [AdminTransaksi::class, 'pembayaran'])->name('pembayaran.index'); // Kelola Data Pembayaran

        // Laporan
        Route::get('/laporan', [AdminLaporan::class, 'index'])->name('laporan.index');
        Route::get('/laporan/pdf', [AdminLaporan::class, 'exportPdf'])->name('laporan.pdf');
    });


// B. AREA PIMPINAN (Akses Read-Only / View)

    Route::middleware(['auth', 'role:pimpinan'])->prefix('pimpinan')->name('pimpinan.')->group(function () {

        // Dashboard Pimpinan
        Route::get('/', [PimpinanDashboard::class, 'index'])->name('dashboard');

        // Monitoring Data Master (Hanya GET/Index saja)
        Route::get('/cluster', [AdminCluster::class, 'index'])->name('cluster.index');
        Route::get('/kavling', [AdminKavling::class, 'index'])->name('kavling.index');

        // Monitoring Operasional (Hanya GET/Index saja)
        Route::get('/pembeli', [AdminPelanggan::class, 'index'])->name('pembeli.index');
        Route::get('/reservasi', [AdminTransaksi::class, 'reservasi'])->name('reservasi.index');
        Route::get('/pembayaran', [AdminTransaksi::class, 'pembayaran'])->name('pembayaran.index');

        // Laporan & Cetak
        Route::get('/laporan', [PimpinanLaporan::class, 'index'])->name('laporan.index');
        Route::get('/laporan/cetak', [PimpinanLaporan::class, 'cetak'])->name('laporan.cetak');
    });

    // C. AREA PEMBELI (Akses Fitur Reservasi & Transaksi)
    Route::middleware(['role:pembeli'])->prefix('pembeli')->name('pembeli.')->group(function () {
        Route::get('/reservasi', [PembeliReservasi::class, 'index'])->name('reservasi.index');
        Route::post('/reservasi', [PembeliReservasi::class, 'store'])->name('reservasi.store');
        Route::get('/pembayaran', [PembeliPembayaran::class, 'index'])->name('pembayaran.index');
        Route::post('/pembayaran', [PembeliPembayaran::class, 'store'])->name('pembayaran.store');

        // Halaman List Kavling & Cek Ketersediaan
        Route::get('/kavling', [PembeliKavling::class, 'index'])->name('kavling.index');
        Route::get('/cluster', [PembeliCluster::class, 'index'])->name('cluster.index');
        Route::get('/pembayaran/invoice/{id}', [PembeliPembayaran::class, 'cetakInvoice'])->name('pembayaran.invoice');
    });
    // PROFIL AREA 
    Route::prefix('profil')->name('profil.')->group(function () {
        Route::get('/', [App\Http\Controllers\Pembeli\ProfilController::class, 'index'])->name('index');
        Route::patch('/update', [App\Http\Controllers\Pembeli\ProfilController::class, 'update'])->name('update');
        Route::put('/password', [App\Http\Controllers\Pembeli\ProfilController::class, 'updatePassword'])->name('password');
        Route::patch('/avatar', [App\Http\Controllers\Pembeli\ProfilController::class, 'updateAvatar'])->name('avatar.update');
    });
});