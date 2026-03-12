<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\AdminLoginController; // <-- Tambahkan ini

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KavlingController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PelangganController;
/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('pembeli.index');
})->name('home');

/*
|--------------------------------------------------------------------------
| 2. GUEST ROUTES (Hanya untuk pengunjung yang BELUM login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    // -- Area Pembeli --
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    Route::get('/login', function () {
        return view('auth.login'); })->name('login');
    Route::get('/register', function () {
        return view('auth.register'); })->name('register');

    // -- Area Login Admin --
    Route::prefix('admin')->name('admin.')->group(function () {

        // Panggil controller untuk menampilkan form login
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');

        // Panggil controller untuk memproses submit login
        Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');

    });

});

/*
|--------------------------------------------------------------------------
| 3. AUTH ROUTES (Hanya untuk user yang SUDAH login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // === AREA DASHBOARD ADMIN ===
    Route::prefix('admin')->name('admin.')->group(function () {

        // Rute-rute utama yang dikendalikan oleh Controller
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/kavling', [KavlingController::class, 'index'])->name('kavling.index');
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');

        // Route untuk proses logout Admin
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
    });

});