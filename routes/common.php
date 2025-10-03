<?php

use App\Http\Controllers\Common\Categories\CategoriesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Common\Products\ProductsController;
use App\Http\Controllers\Common\Attendees\AttendeesController;
use App\Http\Controllers\Common\Orders\OrdersController;
use App\Http\Controllers\Common\Promos\PromosController;
use App\Http\Controllers\Common\Checkins\CheckinsController;
use App\Http\Controllers\Common\Organizations\OrganizationsController;
use App\Http\Controllers\Common\Checkouts\CheckoutsController;
use App\Http\Controllers\Common\Events\EventsController;

// ========================= COMMON ===========================
Route::post('/product/{id}/create', [ProductsController::class, 'store'])->name('products.store');
Route::put('/product/{id}/update', [ProductsController::class, 'update'])->name('products.update');
Route::delete('/product/{id}/destroy', [ProductsController::class, 'destroy'])->name('products.destroy');

Route::put('/attendees/{id}/update', [AttendeesController::class, 'update'])->name('attendees.update');
Route::delete('/attendees/{id}/destroy', [AttendeesController::class, 'delete'])->name('attendees.destroy');

Route::post('/order/{id}/mark-as-paid', [OrdersController::class, 'markAsPaid'])->name('orders.mark-as-paid');
Route::post('/order/{id}/mark-as-pending', [OrdersController::class, 'markAsPending'])->name('orders.mark-as-pending');
Route::put('/order/{id}/update', [OrdersController::class, 'update'])->name('orders.update');
Route::delete('/order/{id}/destroy', [OrdersController::class, 'destroy'])->name('orders.destroy');

Route::post('/promo/{id}/store', [PromosController::class, 'store'])->name('promos.store');
Route::put('/promo/{id}/update', [PromosController::class, 'update'])->name('promos.update');
Route::delete('/promo/{id}/destroy', [PromosController::class, 'destroy'])->name('promos.destroy');
Route::post('/checkout/apply-promo', [PromosController::class, 'applyPromo'])->name('promos.apply');
Route::post('/checkout/remove-promo', [PromosController::class, 'removePromo'])->name('promos.remove');

Route::post('/checkin', [CheckinsController::class, 'processCheckin'])->name('checkins.process');
Route::post('/manual/process', [CheckinsController::class, 'processManualCheckin'])->name('checkins.manual');

Route::post('/organization/store', [OrganizationsController::class, 'store'])->name('organizations.store');

Route::post('/checkout', [CheckoutsController::class, 'checkout'])->name('checkouts');
Route::post('/checkout/submit', [CheckoutsController::class, 'submit'])->name('checkouts.submit');

Route::post('events/store', [EventsController::class, 'store'])->name('events.store');
Route::put('events/{id}/toggle-publish', [EventsController::class, 'togglePublish'])->name('events.togglePublish');
Route::put('events/{id}/update', [EventsController::class, 'update'])->name('events.update');
Route::delete('events/{id}/delete', [EventsController::class, 'destroy'])->name('events.delete');

Route::post('categories/create', [CategoriesController::class, 'create'])->name('categories.store');
Route::delete('categories/{id}/delete', [CategoriesController::class, 'destroy'])->name('categories.delete');
