<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Admin;

Route::get('/', [BlogController::class, 'home'])->name('home');

Route::prefix('newsletter')->name('newsletter.')->group(function () {
    Route::post('/subscribe', [NewsletterController::class, 'subscribe'])
        ->name('subscribe')
        ->middleware('throttle:5,1');
    Route::get('/confirmar/{token}', [NewsletterController::class, 'confirm'])
        ->name('confirm');
});

Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('show');
});

// ── Painel Admin ────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('/login',  [Admin\AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [Admin\AuthController::class, 'login']);
    });

    Route::middleware('admin')->group(function () {
        Route::get('/',       [Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout',[Admin\AuthController::class, 'logout'])->name('logout');

        Route::resource('posts',       Admin\PostController::class);
        Route::resource('categories',  Admin\CategoryController::class);
        Route::resource('tags',        Admin\TagController::class);
        Route::resource('subscribers', Admin\SubscriberController::class)
             ->only(['index', 'destroy']);
    });
});
