<?php

use App\Http\Controllers\Action\{
    AuthController,
    AttendeesActionController,
    CheckinsActionController,
    CheckoutController,
    EventController,
    OrderActionController,
    OrganizationController,
    ProductActionController,
    PromoController
};

use App\Http\Controllers\PageController\{
    AttendeesController,
    BaseController,
    CheckinsController,
    CustomerController,
    DashboardController,
    HomePageController,
    OrderCustomerController,
    OrdersController,
    ProductsController,
    PromoCodesController,
    SettingsController
};
use Google\Service\BinaryAuthorization\Check;
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

Route::get('/auth/logout', [AuthController::class, 'logout'])->name('logout');

// ----------------------------------------- Costumer Page -----------------------------------------
Route::middleware(['auth', 'role:customer,admin'])->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('home');
    Route::get('/event/{id}/detail', [CustomerController::class, 'eventShow'])->name('events.show');
    Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::get('/checkout/{token}', [CustomerController::class, 'showCheckoutForm'])->name('checkout.form');
    Route::post('/checkout/submit', [CheckoutController::class, 'submit'])->name('checkout.submit');

    Route::get('/order', [OrderCustomerController::class, 'index'])->name('orders.customers');
    Route::get('/order/{id}', [OrderCustomerController::class, 'show'])->name('orders.show');
    Route::post('order/{id}/payment-proof', [CheckoutController::class, 'uploadPaymentProof'])->name('payment.proof');

    Route::post('/checkout/apply-promo', [CheckoutController::class, 'applyPromo'])->name('promo.apply');
    Route::post('/checkout/remove-promo', [CheckoutController::class, 'removePromo'])->name('promo.remove');
});

Route::middleware(['auth', 'role:admin'])->group(function () {

    // ----------------------------------------- Home Page -----------------------------------------
    Route::get("/admin", [HomePageController::class, "index"])->name("home.admin");
    Route::get('/admin/{status}', [HomePageController::class, 'index'])->name('status');

    // ----------------------------------------- Logout -----------------------------------------

    // ----------------------------------------- Event -----------------------------------------
    Route::prefix('events/{id}')->name('event.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::get('/checkins', [CheckinsController::class, 'index'])->name('checkins');
        Route::get('/attendees', [AttendeesController::class, 'index'])->name('attendees');
        Route::get('/orders', [OrdersController::class, 'index'])->name('orders');
        Route::get('/orders/{orderId}', [OrdersController::class, 'show'])->name('order.show');
        Route::get('/products', [ProductsController::class, 'index'])->name('products');
        Route::get('/promocodes', [PromoCodesController::class, 'index'])->name('promocodes');
    });
    Route::post('/event/store', [EventController::class, 'store'])->name('event.store');
    Route::put('/event/{id}/update', [EventController::class, 'update'])->name('event.update');
    Route::delete('/event/{id}/delete', [EventController::class, 'destroy'])->name('event.delete');

    // // ----------------------------------------- Product -----------------------------------------
    Route::post('/product/{id}/create', [ProductActionController::class, 'store'])->name('product.store');
    Route::put('/product/{id}/update', [ProductActionController::class, 'update'])->name('product.update');
    Route::delete('/product/{id}/destroy', [ProductActionController::class, 'destroy'])->name('product.destroy');

    // // ----------------------------------------- Attendees -----------------------------------------
    Route::put('/attendees/{id}/update', [AttendeesActionController::class, 'update'])->name('attendees.update');
    Route::delete('/attendees/{id}/destroy', [AttendeesActionController::class, 'destroy'])->name('attendees.destroy');

    // // ----------------------------------------- Order -----------------------------------------
    Route::post('/order/{id}/mark-as-paid', [OrderActionController::class, 'markAsPaid'])->name('order.mark-as-paid');
    Route::post('/order/{id}/mark-as-pending', [OrderActionController::class, 'markAsPending'])->name('order.mark-as-pending');
    Route::put('/order/{id}/update', [OrderActionController::class, 'update'])->name('order.update');
    Route::delete('/order/{id}/destroy', [OrderActionController::class, 'destroy'])->name('order.destroy');

    // // ----------------------------------------- Promo Code -----------------------------------------
    Route::post('/promocode/store', [PromoController::class, 'store'])->name('promocode.store');
    Route::put('/promocode/{id}/update', [PromoController::class, 'update'])->name('promocode.update');
    Route::delete('/promocode/{id}/destroy', [PromoController::class, 'destroy'])->name('promocode.destroy');

    // ----------------------------------------- Organization -----------------------------------------
    Route::post('/organization/store', [OrganizationController::class, 'store'])->name('organization.store');

    // ----------------------------------------- Checkin -----------------------------------------
    Route::post('/checkin', [CheckinsActionController::class, 'processCheckin'])->name('checkin.process');
});
// ----------------------------------------- Timezone -----------------------------------------
Route::post('/set-timezone', function (\Illuminate\Http\Request $request) {
    $tz = $request->timezone ?? 'Asia/Jakarta';
    return response()->json(['status' => 'ok'])
        ->cookie('user_timezone', $tz, 60 * 24 * 30);
});
