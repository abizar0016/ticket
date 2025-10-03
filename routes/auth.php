<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthController;

// ========================= AUTHORIZE ===========================

Route::get('/', function () {
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('home');
    }

    // Superadmin
    if ($user->role === 'superadmin') {
        return redirect()->route('superAdmin.dashboard');
    }

    // Admin
    if ($user->role === 'admin') {
        return redirect()->route('admin.index');
    }

    // Customer
    if ($user->role === 'customer') {
        return redirect()->route('home');
    }

    abort(403);
});

Route::get('/auth/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

Route::get('/auth/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::get('/auth/facebook', [AuthController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('/auth/facebook/callback', [AuthController::class, 'handleFacebookCallback']);

Route::get('/auth/logout', [AuthController::class, 'logout'])->name('logout');
