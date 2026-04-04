<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\VendorController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\Admin\AdminController;

// ─────────────────────────────────────────────────────────────────────────────
// PUBLIC ROUTES (No authentication required)
// ─────────────────────────────────────────────────────────────────────────────

// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Browse
Route::get('/categories',           [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);

Route::get('/products',             [ProductController::class, 'index']);
Route::get('/products/{product}',   [ProductController::class, 'show']);

Route::get('/products/{product}/reviews', [ReviewController::class, 'index']);

// ─────────────────────────────────────────────────────────────────────────────
// PROTECTED ROUTES (auth:sanctum required for everything below)
// ─────────────────────────────────────────────────────────────────────────────

Route::middleware('auth:sanctum')->group(function () {

    // ── Auth & Profile ────────────────────────────────────────────────────────
    Route::post('/logout',  [AuthController::class, 'logout']);
    Route::get('/user',     [AuthController::class, 'profile']);
    Route::put('/user',     [AuthController::class, 'updateProfile']);

    // ── Customer Routes ───────────────────────────────────────────────────────
    Route::middleware('role:customer')->group(function () {

        // Apply to become a vendor
        Route::post('/vendors', [VendorController::class, 'store']);

        // Cart
        Route::get('/cart',                  [CartController::class, 'index']);
        Route::post('/cart',                 [CartController::class, 'add']);
        Route::put('/cart/{cartItem}',       [CartController::class, 'updateQuantity']);
        Route::delete('/cart/{cartItem}',    [CartController::class, 'remove']);
        Route::delete('/cart',               [CartController::class, 'clear']);

        // Orders
        Route::get('/orders',              [OrderController::class, 'index']);
        Route::post('/orders',             [OrderController::class, 'store']);
        Route::get('/orders/{order}',      [OrderController::class, 'show']);

        // Reviews
        Route::post('/products/{product}/reviews', [ReviewController::class, 'store']);
    });

    // ── Vendor Routes ─────────────────────────────────────────────────────────
    Route::middleware('role:vendor')->prefix('vendor')->group(function () {
        Route::put('/profile/{vendor}',         [VendorController::class, 'update']);
        Route::get('/products',                 [ProductController::class, 'vendorProducts']);
        Route::post('/products',                [ProductController::class, 'store']);
        Route::put('/products/{product}',       [ProductController::class, 'update']);
        Route::delete('/products/{product}',    [ProductController::class, 'destroy']);
        Route::get('/orders',                   [OrderController::class, 'vendorOrders']);
    });

    // ── Admin Routes ──────────────────────────────────────────────────────────
    // Both middlewares run: auth:sanctum (already applied above) + admin (checks role=admin)
    Route::middleware('admin')->prefix('admin')->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard']);

        // ── User Management ───────────────────────────────────────────────────
        Route::get('/users',            [AdminController::class, 'users']);
        Route::post('/users',           [AdminController::class, 'store']);
        Route::get('/users/{id}',       [AdminController::class, 'show']);
        Route::put('/users/{id}',       [AdminController::class, 'update']);
        Route::delete('/users/{id}',    [AdminController::class, 'destroy']);

        // ── Category Management ───────────────────────────────────────────────
        Route::post('/categories',              [CategoryController::class, 'store']);
        Route::put('/categories/{category}',    [CategoryController::class, 'update']);
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

        // ── Vendor Approval System ────────────────────────────────────────────
        Route::get('/vendors',                       [AdminController::class, 'vendors']);
        Route::get('/vendors/{id}',                  [AdminController::class, 'showVendor']);
        Route::put('/vendors/{id}/review',           [AdminController::class, 'reviewVendor']);

        // ── Order Management ──────────────────────────────────────────────────
        Route::get('/orders',                        [OrderController::class, 'indexAll']);
        Route::put('/orders/{order}/status',         [OrderController::class, 'updateStatus']);

        // ── Product Moderation ────────────────────────────────────────────────
        Route::get('/products',                      [AdminController::class, 'products']);
        Route::put('/products/{id}/status',          [AdminController::class, 'updateProductStatus']);
        
        // ── Product Approval ──────────────────────────────────────────────────
        Route::get('/approval/products',                 [\App\Http\Controllers\Admin\ProductApprovalController::class, 'index']);
        Route::put('/approval/products/{product}/approve', [\App\Http\Controllers\Admin\ProductApprovalController::class, 'approve']);
        Route::put('/approval/products/{product}/reject',  [\App\Http\Controllers\Admin\ProductApprovalController::class, 'reject']);
    });
});