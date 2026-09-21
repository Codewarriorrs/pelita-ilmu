<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

// Public Landing Page & Pendaftaran
Route::get('/', [RegistrationController::class, 'index'])->name('home');
Route::get('/daftar', [RegistrationController::class, 'create'])->name('pendaftaran');
Route::post('/daftar', [RegistrationController::class, 'store'])->name('daftar.store');

// Auth Login Routes (Custom Pelita Ilmu Style)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
