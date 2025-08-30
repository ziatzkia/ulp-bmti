<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\PermohonanController;
use App\Http\Controllers\User\TrackingController;
use App\Http\Controllers\HumasController;
use App\Http\Controllers\DivisiController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('auth.login'));

Route::middleware(['auth', 'verified'])->group(function () {

    // USER
    Route::middleware(['role:users'])->group(function () {
        Route::get('/user/dashboard', fn() => view('user.dashboard'))->name('user.dashboard');
        Route::get('/user/permohonan', [PermohonanController::class, 'index'])->name('permohonan.index');
        Route::post('/user/permohonan', [PermohonanController::class, 'store'])->name('permohonan.store');
        Route::get('/user/permohonan/{permohonan}/edit', [PermohonanController::class, 'edit']);
        Route::put('/user/permohonan/{permohonan}', [PermohonanController::class, 'update'])->name('permohonan.update');
        Route::delete('/user/permohonan/{permohonan}', [PermohonanController::class, 'destroy'])->name('permohonan.destroy');
        Route::get('/user/tracking', [TrackingController::class, 'index'])->name('tracking');
        Route::get('/user/tracking', [TrackingController::class, 'index'])->name('tracking');
        Route::get('/user/tracking/{permohonan}', [TrackingController::class, 'show'])->name('tracking.show');
    });

    // HUMAS
    Route::middleware(['role:humas'])->group(function () {
        Route::get('/humas/dashboard', [DivisiController::class, 'index'])->name('humas.dashboard');
        Route::get('/dashboard_divisi', [DivisiController::class, 'index'])->name('divisis.index');
        Route::post('/dashboard_divisi', [DivisiController::class, 'store'])->name('divisis.store');
        // Route::post('/divisi/{id}/update-kebutuhan', [DivisiController::class, 'updateKebutuhan'])->name('divisis.updateKebutuhan');
        Route::post('/humas/divisi/{id}/update-kebutuhan', [DivisiController::class, 'updateKebutuhan'])
            ->name('divisis.updateKebutuhan');
        // Route::view('/validasi', 'humas.validasi_surat')->name('validasi');
        Route::view('/unduhan', 'humas.unduhan')->name('unduhan');
        Route::view('/balasan', 'humas.balasan')->name('balasan');

        Route::get('/validasi', [HumasController::class, 'validasiIndex'])->name('humas.validasi.index');
        Route::post('/validasi/{permohonan}', [HumasController::class, 'validasiAction'])->name('humas.validasi.action');
    });


    // DIVISI
    Route::middleware(['role:divisi'])->group(function () {
        // Route::get('/divisi/dashboard', fn() => view('divisi.dashboard'))->name('divisi.dashboard');
        Route::get('/kuota', [DivisiController::class, 'kuota'])->name('kuota');
        Route::put('divisi/{id}/update-kebutuhan', [DivisiController::class, 'updateKebutuhan'])
            ->name('divisi.update-kebutuhan');
    });

    Route::middleware(['role:humas,divisi'])->group(function () {
        Route::get('/dashboard', fn() => view('dashboard'))->name('admin.dashboard');
    });


    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
