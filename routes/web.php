<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\PermohonanController;
use App\Http\Controllers\User\TrackingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth', 'verified')->group(function () {

    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');

    Route::get('/admin/humas/dashboard', function () {
        if (Auth::user()->role !== 'humas') {
            abort(403, 'Unauthorized.');
        }
        return view('admin.humas.dashboard');
    })->name('admin.humas.dashboard');

    Route::get('/admin/divisi/dashboard', function () {
        if (Auth::user()->role !== 'divisi') {
            abort(403, 'Unauthorized.');
        }
        return view('admin.divisi.dashboard');
    })->name('admin.divisi.dashboard');

    Route::get('/user/permohonan', [PermohonanController::class, 'index'])->name('permohonan.index');
    Route::post('/user/permohonan', [PermohonanController::class, 'store'])->name('permohonan.store');
    Route::get('/user/permohonan/{permohonan}/edit', [PermohonanController::class, 'edit']);
    Route::put('/user/permohonan/{permohonan}', [PermohonanController::class, 'update'])->name('permohonan.update');
    Route::delete('/user/permohonan/{permohonan}', [PermohonanController::class, 'destroy'])->name('permohonan.destroy');

    Route::get('/user/tracking', [TrackingController::class, 'index'])->name('tracking');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
