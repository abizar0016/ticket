<?php

use App\Http\Controllers\Attendees\AttendeesController;
use App\Http\Controllers\Authorization\AuthController;
use App\Http\Controllers\Checkout\CheckoutController;
use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Organization\OrganizationController;
use App\Http\Controllers\PageController\CustomerController;
use App\Http\Controllers\PageController\HomePageController;
use App\Http\Controllers\PageController\EventDashboardController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\PromoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;

// ----------------------------------------- Authorization  -----------------------------------------
Route::get('/auth/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

Route::get('/auth/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::get('/auth/facebook', [AuthController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('/auth/facebook/callback', [AuthController::class, 'handleFacebookCallback']);


// ----------------------------------------- Costumer Page -----------------------------------------
Route::middleware(['auth', 'role:customer,admin'])->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('home');
    Route::get('/event/{id}/detail', [CustomerController::class, 'eventShow'])->name('events.show');
    Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::get('/checkout/{token}', [CheckoutController::class, 'showCheckoutForm'])->name('checkout.form');
Route::post('/checkout/submit', [CheckoutController::class, 'submit'])->name('checkout.submit');
});

Route::middleware(['auth', 'role:admin'])->group(function () {

    // ----------------------------------------- Home Page -----------------------------------------
    Route::get("/admin", [HomePageController::class, "index"])->name("home.admin");
    Route::get('/{status}', [HomePageController::class, 'index'])->name('status');

    // ----------------------------------------- Logout -----------------------------------------
    Route::get('/auth/logout', [AuthController::class, 'logout'])->name('logout');

    // ----------------------------------------- Event -----------------------------------------
    Route::get('/event/{id}/manage', [EventDashboardController::class, 'index'])->name('event.manage');
    Route::post('/event/store', [EventController::class, 'store'])->name('event.store');
    Route::put('/event/{id}/update', [EventController::class, 'update'])->name('event.update');
    Route::delete('/event/{id}/delete', [EventController::class, 'destroy'])->name('event.delete');

    // ----------------------------------------- Product -----------------------------------------
    Route::post('/product/{id}/create', [ProductController::class, 'store'])->name('product.store');
    Route::put('/product/{id}/update', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}/destroy', [ProductController::class, 'destroy'])->name('product.destroy');

    // ----------------------------------------- Attendees -----------------------------------------
    Route::put('/attendees/{id}/update', [AttendeesController::class, 'update'])->name('attendees.update');
    Route::delete('/attendees/{id}/destroy', [AttendeesController::class, 'destroy'])->name('attendees.destroy');

    // ----------------------------------------- Order -----------------------------------------
    Route::put('/order/{id}/update', [OrderController::class, 'update'])->name('order.update');
    Route::delete('/order/{id}/destroy', [OrderController::class, 'destroy'])->name('order.destroy');

    // ----------------------------------------- Promo Code -----------------------------------------
    Route::post('/promocode/store', [PromoController::class, 'store'])->name('promocode.store');
    Route::put('/promocode/{id}/update', [PromoController::class, 'update'])->name('promocode.update');
    Route::delete('/promocode/{id}/destroy', [PromoController::class, 'destroy'])->name('promocode.destroy');

    // ----------------------------------------- Organization -----------------------------------------
    Route::post('/organization/store', [OrganizationController::class, 'store'])->name('organization.store');
});
// ----------------------------------------- Timezone -----------------------------------------
Route::post('/set-timezone', function (\Illuminate\Http\Request $request) {
    $tz = $request->timezone ?? 'Asia/Jakarta';
    return response()->json(['status' => 'ok'])
        ->cookie('user_timezone', $tz, 60 * 24 * 30);
});
