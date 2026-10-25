<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

// Public Landing Page & Pendaftaran
Route::get('/', [RegistrationController::class, 'index'])->name('home');
Route::get('/daftar', [RegistrationController::class, 'create'])->name('pendaftaran');
Route::post('/daftar', [RegistrationController::class, 'store'])->name('daftar.store');

// Redirect /admin, /adminlogin, dan /login ke panel /behindpelita
Route::redirect('/admin', '/behindpelita');
Route::redirect('/adminlogin', '/behindpelita')->name('adminlogin');
Route::redirect('/login', '/behindpelita')->name('login');
