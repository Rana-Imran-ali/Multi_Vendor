<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;

// ── FRONTEND ROUTES ──
Route::get('/', function () { return view('front.home'); })->name('home');
Route::get('/shop', function () { return view('front.shop'); })->name('shop');
Route::get('/categories', function () { return view('front.categories'); })->name('categories');
Route::get('/vendors', function () { return view('front.vendors'); })->name('vendors');
Route::get('/about', function () { return view('front.about'); })->name('about');
Route::get('/contact', function () { return view('front.contact'); })->name('contact');
Route::get('/become-seller', function () { return view('front.seller'); })->name('seller.register');
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
Route::post('/logout', function () { return redirect('/')->with('success', 'Logged out.'); })->name('logout');

// ── USER DASHBOARD (Role: Customer/Auth) ──
Route::prefix('user')->group(function () {
    Route::get('/dashboard', function () { return view('user.dashboard'); })->name('user.dashboard');
    Route::get('/profile', function () { return view('user.profile'); })->name('user.profile');
    Route::get('/orders', function () { return view('user.orders'); })->name('user.orders');
});


// ── ADMIN ROUTES ──
Route::prefix('admin')->group(function () {
    Route::get('login', function () { return view('admin.login'); })->name('admin.login');

    // ── Admin Core Dashboards ──
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard.index');
    Route::get('/categories', function () { return view('admin.categories'); })->name('admin.categories');
    Route::get('/products', function () { return view('admin.products'); })->name('admin.products');
    Route::get('/orders', function () { return view('admin.orders'); })->name('admin.orders');
    Route::get('/vendors', function () { return view('admin.vendors'); })->name('admin.vendors');
    Route::get('/users', function () { return view('admin.users'); })->name('admin.users');

    // ── Admin Page Management (AdminLTE sidebar) ──
    Route::prefix('pages')->name('admin.pages.')->group(function () {
        Route::get('/home',     [\App\Http\Controllers\Admin\PageController::class, 'home'])->name('home');
        Route::get('/shop',     [\App\Http\Controllers\Admin\PageController::class, 'shop'])->name('shop');
        Route::get('/product',  [\App\Http\Controllers\Admin\PageController::class, 'product'])->name('product');
        Route::get('/vendor',   [\App\Http\Controllers\Admin\PageController::class, 'vendor'])->name('vendor');
        Route::get('/seller',   [\App\Http\Controllers\Admin\PageController::class, 'seller'])->name('seller');
        Route::get('/blog',     [\App\Http\Controllers\Admin\PageController::class, 'blog'])->name('blog');
        Route::get('/contact',  [\App\Http\Controllers\Admin\PageController::class, 'contact'])->name('contact');
        Route::get('/cart',     [\App\Http\Controllers\Admin\PageController::class, 'cart'])->name('cart');
        Route::get('/checkout', [\App\Http\Controllers\Admin\PageController::class, 'checkout'])->name('checkout');
        Route::get('/auth',     [\App\Http\Controllers\Admin\PageController::class, 'auth'])->name('auth');
    });

    Route::group(['middleware' => 'admin'], function () {
        // Keep existing controller logic if any controllers point to real stuff
        Route::resource('dashboard_resource', AdminController::class)->only(['index']);
    });
});