<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Creator\Profile\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Creator\Profile\CreatorPlatformController;

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('loginDashboard');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



Route::middleware([\App\Http\Middleware\AuthMiddleware::class])->group(function () {
    
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');


    Route::get('/test', [CreatorPlatformController::class, 'test'])->name('test');
    
    Route::get('/social-platform-add', [CreatorPlatformController::class, 'create'])->name('social-platform-create');
    Route::post('/social-platform-add', [CreatorPlatformController::class, 'store'])->name('social-platform-add');
});
