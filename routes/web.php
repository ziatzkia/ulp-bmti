<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\PermohonanController;
use App\Http\Controllers\User\TrackingController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('auth.login'));

Route::middleware(['auth', 'verified'])->group(function () {

    // USER
    Route::middleware(['role:user'])->group(function () {
        Route::get('/user/dashboard', fn() => view('user.dashboard'))->name('user.dashboard');
        Route::get('/user/permohonan', [PermohonanController::class, 'index'])->name('permohonan.index');
        Route::post('/user/permohonan', [PermohonanController::class, 'store'])->name('permohonan.store');
        Route::get('/user/permohonan/{permohonan}/edit', [PermohonanController::class, 'edit']);
        Route::put('/user/permohonan/{permohonan}', [PermohonanController::class, 'update'])->name('permohonan.update');
        Route::delete('/user/permohonan/{permohonan}', [PermohonanController::class, 'destroy'])->name('permohonan.destroy');
        Route::get('/user/tracking', [TrackingController::class, 'index'])->name('tracking');
    });

    // HUMAS
    Route::middleware(['role:humas'])->group(function () {
        Route::get('/humas/dashboard', fn() => view('humas.dashboard_divisi'))->name('humas.dashboard');
        Route::view('/dashboard_divisi', 'humas.dashboard_divisi')->name('dashboard_divisi');
        Route::view('/validasi', 'humas.validasi_surat')->name('validasi');
        Route::view('/unduhan', 'humas.unduhan')->name('unduhan');
        Route::view('/balasan', 'humas.balasan')->name('balasan');
    });

    // DIVISI
    Route::middleware(['role:divisi'])->group(function () {
        Route::get('/divisi/dashboard', fn() => view('divisi.dashboard'))->name('divisi.dashboard');
        Route::view('/divisi', 'divisi.dashboard')->name('divisi');
    });

    Route::middleware(['role:humas,divisi'])->group(function () {
        Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    });
    

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
