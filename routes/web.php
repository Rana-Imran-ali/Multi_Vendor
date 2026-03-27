<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;

Route::get('/', function () { return view('pages.home'); })->name('home');
Route::get('/shop', function () { return view('pages.shop'); })->name('shop');
Route::get('/product-details', function () { return view('pages.product-details'); })->name('product-details');
Route::get('/cart', function () { return view('pages.cart'); })->name('cart');
Route::get('/checkout', function () { return view('pages.checkout'); })->name('checkout');
Route::get('/login', function () { return view('pages.login'); })->name('login');
Route::get('/register', function () { return view('pages.register'); })->name('register');
Route::get('/vendor-dashboard', function () { return view('pages.vendor-dashboard'); })->name('vendor.dashboard');
// Route::get('login', [AdminController::class, 'create'])->name('admin.login');   

// // Route::resource('admin/dashboard', AdminController::class);->only(['index']);
// Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard.index');
Route::prefix('admin') ->group(function () {
    Route::get('login', [AdminController::class, 'create'])->name('admin.login');   
    Route::group(['middleware' => 'admin'], function () {
        Route::resource('dashboard', AdminController::class)->only(['index']);

        // Pages Management Routes
        Route::prefix('pages')->name('admin.pages.')->group(function () {
            Route::get('home', [\App\Http\Controllers\Admin\PageController::class, 'home'])->name('home');
            Route::get('shop', [\App\Http\Controllers\Admin\PageController::class, 'shop'])->name('shop');
            Route::get('product', [\App\Http\Controllers\Admin\PageController::class, 'product'])->name('product');
            Route::get('vendor', [\App\Http\Controllers\Admin\PageController::class, 'vendor'])->name('vendor');
            Route::get('seller', [\App\Http\Controllers\Admin\PageController::class, 'seller'])->name('seller');
            Route::get('blog', [\App\Http\Controllers\Admin\PageController::class, 'blog'])->name('blog');
            Route::get('contact', [\App\Http\Controllers\Admin\PageController::class, 'contact'])->name('contact');
            Route::get('cart', [\App\Http\Controllers\Admin\PageController::class, 'cart'])->name('cart');
            Route::get('checkout', [\App\Http\Controllers\Admin\PageController::class, 'checkout'])->name('checkout');
            Route::get('auth', [\App\Http\Controllers\Admin\PageController::class, 'auth'])->name('auth');
        });
    });
});