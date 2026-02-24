<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ImpianController;

Route::get('/', function () {
    return view('welcome');
});

// Route yang dilindungi otentikasi
Route::middleware('auth')->group(function () {
    Route::get('/', [ImpianController::class, 'index'])->name('dashboard');
    Route::post('/impian', [ImpianController::class, 'store'])->name('impian.store');
    Route::post('/impian/{impian}/transaksi', [App\Http\Controllers\TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/profile', [App\Http\Controllers\Auth\GoogleController::class, 'editProfile'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\Auth\GoogleController::class, 'updateProfile'])->name('profile.update');
});

// Jika belum login, tampilkan halaman awal (welcome)
Route::get('/login', function () {
    return view('welcome');
})->name('login');

// Route untuk Google Auth
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::post('logout', [GoogleController::class, 'logout'])->name('logout');