<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

// ============= SUPER ADMIN ===============
use App\Http\Controllers\SuperAdmin\Pages\{
    SuperAdminDashboardController,
    SuperAdminAlleventsController,
};

use App\Http\Controllers\SuperAdmin\Pages\Events\{
    SuperAdminEventsDashboardController,
    SuperAdminEventsSettingsController,
};

// =============== ADMIN ===============
use App\Http\Controllers\Admin\Pages\{
    AdminAttendeesController,
    AdminCheckinsController,
    AdminDashboardController,
    AdminHomeController,
    AdminOrdersController,
    AdminProductsController,
    AdminPromoController,
    AdminSettingsController
};

use App\Http\Controllers\Admin\Actions\{
    AdminManageAttendeesController,
    AdminManageCheckinsController,
    AdminManageEventController,
    AdminManageOrderController,
    AdminManageOrganizationController,
    AdminManageProductController,
    AdminManagePromoController
};

// ============= CUSTOMERS ===============
use App\Http\Controllers\Customers\Pages\{
    CustomersHomeController,
    CustomersOrderController
};

use App\Http\Controllers\Customers\Actions\{
    CustomersCheckoutController,
    CustomersPromoController
};

// ========================= AUTHORIZE ===========================
Route::get('/', function () {
    $user = Auth::user();

    if ($user->role === 'superadmin') {
        return redirect()->route('superAdmin.dashboard');
    }

    if ($user->role === 'admin') {
        return redirect()->route('home.admin');
    }

    if ($user->role === 'customer') {
        return redirect()->route('home.customer');
    }

    abort(403);
})->middleware('auth');
Route::get('/auth/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

Route::get('/auth/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::get('/auth/facebook', [AuthController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('/auth/facebook/callback', [AuthController::class, 'handleFacebookCallback']);

Route::get('/auth/logout', [AuthController::class, 'logout'])->name('logout');

// ========================= ORGANIZATION ===========================
Route::post('/organization/store', [AdminManageOrganizationController::class, 'store'])->name('organization.store');

// ========================= SUPER ADMIN ===========================
// routes/web.php
Route::middleware(['auth', 'role:superadmin'])
    ->prefix('superadmin')
    ->name('superAdmin.')
    ->group(function () {
        Route::get('/', [SuperAdminDashboardController::class, "index"])->name('dashboard');
        Route::get('/all-events', [SuperAdminAllEventsController::class, 'index'])->name('allEvents');

        Route::prefix('events/{eventId}')
            ->name('events.')
            ->group(function () {
                Route::get('/dashboard', [SuperAdminEventsDashboardController::class, 'index'])->name('dashboard');
                Route::get('/settings', [SuperAdminEventsSettingsController::class, 'index'])->name('settings');
                Route::get('/attendees', [SuperAdminEventsAttendeesController::class, 'index'])->name('attendees');
            });
    });

// ========================= ADMIN ===========================
Route::middleware(['auth', 'role:superadmin,admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/', [AdminHomeController::class, "index"])->name("home.admin");
        Route::get('/{status}', [AdminHomeController::class, 'index'])->name('status');

        // ----------------------------------------- Event -----------------------------------------
        Route::prefix('events')->name('event.')->group(function () {
            Route::post('/store', [AdminManageEventController::class, 'store'])->name('store');
            Route::put('/{id}/update', [AdminManageEventController::class, 'update'])->name('update');
            Route::delete('/{id}/delete', [AdminManageEventController::class, 'destroy'])->name('delete');

            Route::prefix('{id}')->group(function () {
                Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
                Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings');
                Route::get('/checkins', [AdminCheckinsController::class, 'index'])->name('checkins');
                Route::get('/attendees', [AdminAttendeesController::class, 'index'])->name('attendees');
                Route::get('/orders', [AdminOrdersController::class, 'index'])->name('orders');
                Route::get('/orders/{orderId}', [AdminOrdersController::class, 'show'])->name('orders.show');
                Route::get('/products', [AdminProductsController::class, 'index'])->name('products');
                Route::get('/promocodes', [AdminPromoController::class, 'index'])->name('promocodes');
            });
        });

        Route::post('/product/{id}/create', [AdminManageProductController::class, 'store'])->name('product.store');
        Route::put('/product/{id}/update', [AdminManageProductController::class, 'update'])->name('product.update');
        Route::delete('/product/{id}/destroy', [AdminManageProductController::class, 'destroy'])->name('product.destroy');

        Route::put('/attendees/{id}/update', [AdminManageAttendeesController::class, 'update'])->name('attendees.update');
        Route::delete('/attendees/{id}/destroy', [AdminManageAttendeesController::class, 'destroy'])->name('attendees.destroy');

        Route::post('/order/{id}/mark-as-paid', [AdminManageOrderController::class, 'markAsPaid'])->name('order.mark-as-paid');
        Route::post('/order/{id}/mark-as-pending', [AdminManageOrderController::class, 'markAsPending'])->name('order.mark-as-pending');
        Route::put('/order/{id}/update', [AdminManageOrderController::class, 'update'])->name('order.update');
        Route::delete('/order/{id}/destroy', [AdminManageOrderController::class, 'destroy'])->name('order.destroy');

        Route::post('/promocode/{id}/store', [AdminManagePromoController::class, 'store'])->name('promocode.store');
        Route::put('/promocode/{id}/update', [AdminManagePromoController::class, 'update'])->name('promocode.update');
        Route::delete('/promocode/{id}/destroy', [AdminManagePromoController::class, 'destroy'])->name('promocode.destroy');

        Route::post('/checkin', [AdminManageCheckinsController::class, 'processCheckin'])->name('checkin.process');
        Route::post('/manual/process', [AdminManageCheckinsController::class, 'processManualCheckin'])->name('manual.checkin');
    });

// ========================= CUSTOMERS ===========================
Route::middleware(['auth', 'role:customer,admin,superadmin'])
    ->prefix('customer')
    ->group(function () {
        Route::get('/', [CustomersHomeController::class, 'index'])->name('home.customer');
        Route::get('/event/{id}/detail', [CustomersHomeController::class, 'eventShow'])->name('events.show');

        Route::post('/checkout', [CustomersCheckoutController::class, 'checkout'])->name('checkout');
        Route::get('/checkout/{token}', [CustomersHomeController::class, 'showCheckoutForm'])->name('checkout.form');
        Route::post('/checkout/submit', [CustomersCheckoutController::class, 'submit'])->name('checkout.submit');
        Route::post('/checkout/apply-promo', [CustomersPromoController::class, 'applyPromo'])->name('promo.apply');
        Route::post('/checkout/remove-promo', [CustomersPromoController::class, 'removePromo'])->name('promo.remove');

        Route::get('/order', [CustomersOrderController::class, 'index'])->name('orders.customers');
        Route::get('/order/{id}', [CustomersOrderController::class, 'show'])->name('orders.show');
        Route::post('/order/{id}/payment-proof', [CustomersCheckoutController::class, 'uploadPaymentProof'])->name('payment.proof');
    });