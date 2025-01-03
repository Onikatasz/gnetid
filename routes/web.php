<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SubscriptionController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/subscription')->group(function () {
    Route::get('/payment/{id}', [SubscriptionController::class, 'payment'])->name('subscription.payment');
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

    Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('client.dashboard');
    
    Route::prefix('/ticket')->group(function () {
        Route::get('/', [TicketController::class, 'checkMyTicket'])->name('ticket.checkMyTicket');
        Route::get('/create', [TicketController::class, 'createMyTicket'])->name('ticket.createMyTicket');
        Route::post('/store', [TicketController::class, 'storeMyTicket'])->name('ticket.storeMyTicket');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('/client')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('client.index');
        Route::get('/search', [ClientController::class, 'searchByPhoneOrName'])->name('client.searchByPhoneOrName');
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

    Route::prefix('/ticket')->group(function () {
        Route::get('/', [TicketController::class, 'index'])->name('ticket.index');
        Route::get('/create', [TicketController::class, 'create'])->name('ticket.create');
        Route::post('/store', [TicketController::class, 'store'])->name('ticket.store');
        Route::get('/{ticket}', [TicketController::class, 'show'])->name('ticket.show');
        Route::get('/{ticket}/edit', [TicketController::class, 'edit'])->name('ticket.edit');
        Route::put('/{ticket}', [TicketController::class, 'update'])->name('ticket.update');
        Route::delete('/{ticket}', [TicketController::class, 'destroy'])->name('ticket.destroy');
    });

    Route::prefix('/message')->group(function () {
        Route::get('/send-messages-test', [MessageController::class, 'sendMessagesTest'])->name('message.sendMessagesTest');
        Route::get('/send-text', [MessageController::class, 'showSendTextForm'])->name('message.showSendTextForm');
        Route::post('/send-text', [MessageController::class, 'sendText'])->name('message.sendText');
        Route::get('/send-broadcast', [MessageController::class, 'showSendBroadcastForm'])->name('message.showSendBroadcastForm');
        Route::post('/send-broadcast', [MessageController::class, 'sendBroadcast'])->name(name: 'message.sendBroadcast');
        Route::get('/send-billing/{phone}', [MessageController::class, 'sendBillingByText'])->name('message.sendBillingByText');
    });

    Route::prefix('/subscription')->group(function () {
        Route::put('/{id}', [SubscriptionController::class, 'update'])->name('subscription.update');
    });
    
    
});