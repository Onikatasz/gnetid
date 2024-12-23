<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Auth routes
Route::prefix('/auth')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});
