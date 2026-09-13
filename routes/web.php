<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landingpage');
})->name('beranda');

Route::get('/pendaftaran', function () {
    return view('pendaftaran');
})->name('pendaftaran');

