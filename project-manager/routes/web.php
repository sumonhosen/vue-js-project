<?php

use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

// Other Pages
Route::get('/', [PageController::class, 'homepage'])->name('homepage');

Auth::routes();

// Test Routes
// Route::get('test',             [TestController::class, 'test'])->name('test');
Route::get('cache-clear',      [TestController::class, 'cacheClear'])->name('cacheClear');
// Route::get('config',           [TestController::class, 'config'])->name('config');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
