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

// Direct Excel Download for Rekap Presensi Matrix
Route::get('/behindpelita/rekap-presensi-matrix/export', \App\Http\Controllers\RekapPresensiExportController::class)
    ->middleware(['web', 'auth'])
    ->name('rekap-presensi.export');

// Notification Center Feed for Admin/Tentor
Route::get('/behindpelita/notifications/feed', \App\Http\Controllers\NotificationFeedController::class)
    ->middleware(['web', 'auth'])
    ->name('notifications.feed');

// Onboarding Tour Dismiss
Route::post('/behindpelita/onboarding/dismiss', function (\Illuminate\Http\Request $request) {
    if (auth()->check()) {
        auth()->user()->update(['hide_onboarding_tour' => true]);
        session()->forget('show_onboarding_tour');
        return response()->json(['success' => true]);
    }
    return response()->json(['error' => 'Unauthenticated'], 401);
})->middleware(['web', 'auth'])->name('onboarding.dismiss');

