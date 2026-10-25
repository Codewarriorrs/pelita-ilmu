<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

// Public Landing Page & Pendaftaran
Route::get('/', [RegistrationController::class, 'index'])->name('home');
Route::get('/daftar', [RegistrationController::class, 'create'])->name('pendaftaran');
Route::post('/daftar', [RegistrationController::class, 'store'])->name('daftar.store');

// Route Autentikasi Utama: /behindpelita & /adminlogin (Filament Native Login)
Route::redirect('/behindpelita', '/admin/login')->name('behindpelita');
Route::redirect('/adminlogin', '/behindpelita')->name('adminlogin');
Route::redirect('/login', '/behindpelita')->name('login');
