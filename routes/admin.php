<?php

use App\Http\Controllers\Admin\Pages\Events\AdminReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Pages\Home\AdminHomeController;
use App\Http\Controllers\Admin\Pages\Events\AdminDashboardController;
use App\Http\Controllers\Admin\Pages\Events\AdminSettingsController;
use App\Http\Controllers\Admin\Pages\Events\AdminCheckinsController;
use App\Http\Controllers\Admin\Pages\Events\AdminAttendeesController;
use App\Http\Controllers\Admin\Pages\Events\AdminOrdersController;
use App\Http\Controllers\Admin\Pages\Events\AdminProductsController;
use App\Http\Controllers\Admin\Pages\Events\AdminPromoController;

// ========================= ADMIN ===========================
Route::middleware(['auth', 'role:superadmin,admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminHomeController::class, 'index'])->name('index');
        Route::get('/{status}', [AdminHomeController::class, 'index'])->name('events.status');

        // ----------------------------------------- Event -----------------------------------------
        Route::prefix('events')->name('events.')->group(function () {
            Route::prefix('{id}')->group(function () {
                Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
                Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings');
                Route::get('/checkins', [AdminCheckinsController::class, 'index'])->name('checkins');
                Route::get('/attendees', [AdminAttendeesController::class, 'index'])->name('attendees');
                Route::get('/orders', [AdminOrdersController::class, 'index'])->name('orders');
                Route::get('/orders/{orderId}', [AdminOrdersController::class, 'show'])->name('orders.show');
                Route::get('/products', [AdminProductsController::class, 'index'])->name('products');
                Route::get('/promo', [AdminPromoController::class, 'index'])->name('promos');
                Route::get('/reports', [AdminReportController::class, 'index'])->name('reports');
                Route::get('/reports/{reportId}', [AdminReportController::class, 'show'])->name('reports.show');
            });
        });
    });
