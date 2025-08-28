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

    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    Route::get('/humas/dashboard', function () {
        if (Auth::user()->role !== 'humas') {
            abort(403, 'Unauthorized.');
        }
        return view('humas.dashboard');
    })->name('humas.dashboard');

    Route::get('/divisi/dashboard', function () {
        if (Auth::user()->role !== 'divisi') {
            abort(403, 'Unauthorized.');
        }
        return view('divisi.dashboard');
    })->name('divisi.dashboard');

    Route::get('/user/permohonan', [PermohonanController::class, 'index'])->name('permohonan.index');
    Route::post('/user/permohonan', [PermohonanController::class, 'store'])->name('permohonan.store');
    Route::get('/user/permohonan/{permohonan}/edit', [PermohonanController::class, 'edit']);
    Route::put('/user/permohonan/{permohonan}', [PermohonanController::class, 'update'])->name('permohonan.update');
    Route::delete('/user/permohonan/{permohonan}', [PermohonanController::class, 'destroy'])->name('permohonan.destroy');

    Route::get('/user/tracking', [TrackingController::class, 'index'])->name('tracking');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


 
Route::view('/dashboard', 'humas.dashboard')->name('dashboard');
Route::view('/operator', 'humas.operator')->name('operator');
Route::view('/penjab', 'humas.penjab')->name('penjab');
Route::view('/staff', 'humas.staff')->name('staff');


Route::view('/divisi', 'divisi.dashboard')->name('divisi');

});


require __DIR__ . '/auth.php';
