<?php

use App\Http\Controllers\BkashController;
use Illuminate\Support\Facades\Route;

// web.php
Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('/pay', [BkashController::class, 'showForm'])->name('payment.form');
Route::post('/pay', [BkashController::class, 'createPayment'])->name('payment.create');
Route::get('/pay/status', [BkashController::class, 'callback'])->name('payment.callback');
