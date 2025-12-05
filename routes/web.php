<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Frontend\UserOrderController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\CartController;
use Illuminate\Support\Facades\Route;

// FRONTEND
Route::get('/', [ShopController::class, 'home'])->name('home');
Route::get('/products', [ShopController::class, 'products'])->name('products.index');
Route::get('/products/{product}', [ShopController::class, 'show'])->name('products.show');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
// Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('user.orders');
Route::get('/my-orders', [UserOrderController::class, 'index'])
    ->middleware('auth')
    ->name('user.orders');


// BREEZE AUTH ROUTES
require __DIR__.'/auth.php';

// CART (AUTH REQUIRED)
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
});

// ADMIN AUTH
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');

// ADMIN DASHBOARD (PROTECTED)
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
    
    // PRODUCTS
    Route::resource('products', AdminProductController::class);

    // ORDERS
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])
    ->name('orders.invoice');
    Route::delete('/admin/orders/{order}', [OrderController::class, 'destroy'])
    ->name('orders.destroy');


    // LOGOUT
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

    

