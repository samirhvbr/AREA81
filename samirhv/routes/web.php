<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\NewsletterController;

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
