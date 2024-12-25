<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SubscriptionPlanController;

Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Route::prefix('/auth')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});

Route::prefix('/client')->group(function () {
    Route::get('/login', [ClientController::class, 'showLoginClientForm'])->name('showLoginClientForm');
    Route::post('/login', [ClientController::class, 'login'])->name('client.login');
    Route::post('/logout', [ClientController::class, 'logout'])->name('client.logout');
});

Route::middleware(['auth:client'])->group(function () {
    Route::prefix('/client')->group(function () {
        Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('client.dashboard');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('/client')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('client.index');
        Route::get('/create', [ClientController::class, 'create'])->name('client.create');
        Route::post('/store', [ClientController::class, 'store'])->name('client.store');
        Route::get('/{client}', [ClientController::class, 'show'])->name('client.show');
        Route::get('/{client}/edit', [ClientController::class, 'edit'])->name('client.edit');
        Route::put('/{client}', [ClientController::class, 'update'])->name('client.update');
        Route::delete('/{client}', [ClientController::class, 'destroy'])->name('client.destroy');
    });

    Route::prefix('/subscription-plan')->group(function () {
        Route::get('/', [SubscriptionPlanController::class, 'index'])->name('subscription_plan.index');
        Route::get('/create', [SubscriptionPlanController::class, 'create'])->name('subscription_plan.create');
        Route::post('/store', [SubscriptionPlanController::class, 'store'])->name('subscription_plan.store');
        Route::get('/{subscriptionPlan}', [SubscriptionPlanController::class, 'show'])->name('subscription_plan.show');
        Route::get('/{subscriptionPlan}/edit', [SubscriptionPlanController::class, 'edit'])->name('subscription_plan.edit');
        Route::put('/{subscriptionPlan}', [SubscriptionPlanController::class, 'update'])->name('subscription_plan.update');
        Route::delete('/{subscriptionPlan}', [SubscriptionPlanController::class, 'destroy'])->name('subscription_plan.destroy');
    });

    
});