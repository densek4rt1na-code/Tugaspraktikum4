<?php

use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporWargaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/lapor');
Route::get('/lapor', [LaporWargaController::class, 'create'])->name('lapor.create');
Route::post('/lapor', [LaporWargaController::class, 'store'])->name('lapor.store');


Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::resource('laporan', LaporanController::class)
        ->parameters(['laporan' => 'laporan']);

    Route::get('/profil', [LoginController::class, 'profile'])->name('petugas.profile');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
