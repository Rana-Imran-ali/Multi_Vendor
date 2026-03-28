<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;

// ── FRONTEND ROUTES ──
Route::get('/', function () { return view('front.home'); })->name('home');
Route::get('/shop', function () { return view('front.shop'); })->name('shop');
Route::get('/categories', function () { return view('front.categories'); })->name('categories');
Route::get('/vendors', function () { return view('front.vendors'); })->name('vendors');
Route::get('/about', function () { return view('front.about'); })->name('about');
Route::get('/blog', function () { return view('front.blog'); })->name('blog');
Route::get('/wishlist', function () { return view('front.wishlist'); })->name('wishlist');
Route::get('/deals', function () { return view('front.deals'); })->name('deals');
Route::get('/products/{slug}', function ($slug) { return view('front.product-detail'); })->name('product-details');
Route::get('/cart', function () { return view('front.cart'); })->name('cart');
Route::get('/checkout', function () { return view('front.checkout'); })->name('checkout');
Route::get('/vendors/{slug}', function ($slug) { return view('front.vendor-store'); })->name('vendor.store');

// ── AUTHENTICATION ROUTES (UI Only Demo) ──
Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::post('/login', function () { return back()->with('error', 'This is a UI demo.'); });
Route::get('/register', function () { return view('auth.register'); })->name('register');
Route::post('/register', function () { return back()->with('error', 'This is a UI demo.'); });


// ── ADMIN ROUTES ──
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminController::class, 'create'])->name('admin.login');   

    // Using closure routes for UI mockups temporarily
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard.index');
    Route::get('/products', function () { return view('admin.products'); })->name('admin.products');
    Route::get('/orders', function () { return view('admin.orders'); })->name('admin.orders');
    Route::get('/vendors', function () { return view('admin.vendors'); })->name('admin.vendors');
    Route::get('/users', function () { return view('admin.users'); })->name('admin.users');

    Route::group(['middleware' => 'admin'], function () {
        // Keep existing controller logic if any controllers point to real stuff
        Route::resource('dashboard_resource', AdminController::class)->only(['index']);
    });
});