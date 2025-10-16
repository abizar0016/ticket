<?php

use App\Http\Controllers\SuperAdmin\Activity\SuperAdminActivityController;
use App\Http\Controllers\SuperAdmin\Categories\SuperAdminCatergoriesController;
use App\Http\Controllers\SuperAdmin\CustomersReports\SuperAdminCustomersReportsController;
use App\Http\Controllers\SuperAdmin\Dashboard\SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\Events\SuperAdminEventsAttendeesController;
use App\Http\Controllers\SuperAdmin\Events\SuperAdminEventsCheckinsController;
use App\Http\Controllers\SuperAdmin\Events\SuperAdminEventsController;
use App\Http\Controllers\SuperAdmin\Events\SuperAdminEventsDashboardController;
use App\Http\Controllers\SuperAdmin\Events\SuperAdminEventsOrdersController;
use App\Http\Controllers\SuperAdmin\Events\SuperAdminEventsProductsController;
use App\Http\Controllers\SuperAdmin\Events\SuperAdminEventsPromosController;
use App\Http\Controllers\SuperAdmin\Events\SuperAdminEventsReportsController;
use App\Http\Controllers\SuperAdmin\Events\SuperAdminEventsSettingsController;
use App\Http\Controllers\SuperAdmin\Orders\SuperAdminOrdersController;
use App\Http\Controllers\SuperAdmin\Orders\SuperAdminRevenueReportController;
use App\Http\Controllers\SuperAdmin\Users\SuperAdminOrganizationsController;
use App\Http\Controllers\SuperAdmin\Users\SuperAdminUsersController;
use Illuminate\Support\Facades\Route;

// ========================= SUPER ADMIN ===========================
Route::middleware(['auth', 'role:superadmin'])
    ->prefix('superadmin')
    ->name('superAdmin.')
    ->group(function () {
        Route::get('/', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/events', [SuperAdminEventsController::class, 'index'])->name('events');
        Route::get('/events/{status}', [SuperAdminEventsController::class, 'index'])->name('events.status');

        Route::get('/categories', [SuperAdminCatergoriesController::class, 'index'])->name('events.categories');
        Route::get('/orders', [SuperAdminOrdersController::class, 'index'])->name('orders');
        Route::get('/revenue-reports', [SuperAdminRevenueReportController::class, 'index'])->name('revenue-reports');
        Route::get('/users', [SuperAdminUsersController::class, 'index'])->name('users');
        Route::get('/organizations', [SuperAdminOrganizationsController::class, 'index'])->name('organizations');
        Route::get('/customers-reports', [SuperAdminCustomersReportsController::class, 'index'])->name('customers-reports');
        Route::get('/customers-reports/{id}', [SuperAdminCustomersReportsController::class, 'show'])->name('reports.show');
        Route::get('/log-activity', [SuperAdminActivityController::class, 'index'])->name('activities');
        
        Route::prefix('events/{eventId}')->name('events.')->group(function () {
            Route::get('/dashboard', [SuperAdminEventsDashboardController::class, 'index'])->name('dashboard');
            Route::get('/settings', [SuperAdminEventsSettingsController::class, 'index'])->name('settings');
            Route::get('/attendees', [SuperAdminEventsAttendeesController::class, 'index'])->name('attendees');
            Route::get('/orders', [SuperAdminEventsOrdersController::class, 'index'])->name('orders');
            Route::get('/orders/{orderId}', [SuperAdminEventsOrdersController::class, 'show'])->name('orders.show');
            Route::get('/products', [SuperAdminEventsProductsController::class, 'index'])->name('products');
            Route::get('/checkins', [SuperAdminEventsCheckinsController::class, 'index'])->name('checkins');
            Route::get('/promos', [SuperAdminEventsPromosController::class, 'index'])->name('promos');
            Route::get('/reports', [SuperAdminEventsReportsController::class, 'index'])->name('reports');
            Route::get('/show/{orderId}', [SuperAdminEventsPromosController::class, 'show'])->name('orders.show');
        });
    });
