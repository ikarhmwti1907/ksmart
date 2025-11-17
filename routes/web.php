<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;

// login & Logout
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Lupa Password 
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot.password');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot.password.send');

// Profile
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// Kelola Barang
    Route::get('/barang/search', [BarangController::class, 'search'])
     ->name('barang.search');

    Route::resource('barang', BarangController::class)->middleware('auth');


// Kelola Transaksi
Route::resource('transaksi', TransaksiController::class)->middleware('auth');

// Laporan
Route::middleware('auth')->group(function () {
    
    // Laporan Barang
    Route::get('/laporan/barang', [LaporanController::class, 'laporanBarang'])
        ->name('laporan.barang');

    // Laporan Transaksi
    Route::get('laporan/transaksi', [LaporanController::class, 'transaksi']);


});