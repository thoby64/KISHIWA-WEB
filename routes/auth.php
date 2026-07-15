<?php

use App\Http\Controllers\Auth\SecureLoginController;
use Illuminate\Support\Facades\Route;

// Override the default login route to use our secure login controller
Route::get('login', [SecureLoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [SecureLoginController::class, 'login']);
Route::post('logout', [SecureLoginController::class, 'logout'])->name('logout');