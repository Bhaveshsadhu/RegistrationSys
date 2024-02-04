<?php

use App\Http\Controllers\AuthController;
//use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Route;

// Registration routes
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Account activation route
Route::get('/activate/{token}', [AuthController::class, 'activateAccount'])->name('activate');

// Login routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Welcome route
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// Logout route
Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');
