<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/products', function () {
    return view('products');
});

Route::get('/login', function () {
    return view('login'); // Vista de login en Laravel, o Vue la maneja completamente
});

Route::post('/login', [AuthController::class, 'login']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

