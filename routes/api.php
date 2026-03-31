<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\VendorController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\Admin\AdminController;


// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

Route::get('/products/{product}/reviews', [ReviewController::class, 'index']);

// Protected Routes (Require Authentication)
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth & Profile
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'profile']);
    Route::put('/user', [AuthController::class, 'updateProfile']);

    // ==========================================
    // CUSTOMER ROUTES (Requires 'customer' role)
    // ==========================================
    Route::middleware('role:customer')->group(function () {
        // Common Authenticated User Actions
        Route::post('/vendors', [VendorController::class, 'store']); // Apply to become vendor
        
        // Cart System
        Route::get('/cart', [CartController::class, 'index']);
        Route::post('/cart', [CartController::class, 'add']);
        Route::put('/cart/{cartItem}', [CartController::class, 'updateQuantity']);
        Route::delete('/cart/{cartItem}', [CartController::class, 'remove']);
        Route::delete('/cart', [CartController::class, 'clear']);

        // Order System (User)
        Route::get('/orders', [OrderController::class, 'index']);
        Route::post('/orders', [OrderController::class, 'store']);
        Route::get('/orders/{order}', [OrderController::class, 'show']);

        // Reviews (User)
        Route::post('/products/{product}/reviews', [ReviewController::class, 'store']);
    });

    // ==========================================
    // VENDOR ROUTES (Requires 'vendor' role)
    // ==========================================
    Route::middleware('role:vendor')->prefix('vendor')->group(function () {
        Route::put('/profile/{vendor}', [VendorController::class, 'update']);
        Route::get('/products', [ProductController::class, 'vendorProducts']);
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{product}', [ProductController::class, 'update']);
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);
        Route::get('/orders', [OrderController::class, 'vendorOrders']);
    });

    // ==========================================
    // ADMIN ROUTES (Requires 'admin' role)
    // ==========================================
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        // Categories CRUD
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{category}', [CategoryController::class, 'update']);
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

        // Vendors
        Route::get('/vendors', [VendorController::class, 'index']);
        Route::get('/vendors/{vendor}', [VendorController::class, 'show']);
        Route::put('/vendors/{vendor}/approve', [VendorController::class, 'approve']);

        // Orders
        Route::get('/orders', [OrderController::class, 'indexAll']);
        Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus']);
    });
});
    // Admin Routes
    Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {

    Route::get('/users', [AdminController::class, 'users']);
    Route::get('/users/{id}', [AdminController::class, 'show']);
    Route::put('/users/{id}', [AdminController::class, 'update']);
    Route::delete('/users/{id}', [AdminController::class, 'delete']);

    Route::get('/dashboard', [AdminController::class, 'dashboard']);

    Route::post('/approve-vendor/{id}', [AdminController::class, 'approveVendor']);

});