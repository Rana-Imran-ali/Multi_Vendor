<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;

Route::get('/', function () {
    return view('welcome');
});

// Route::resource('admin/dashboard', AdminController::class);->only(['index']);
Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard.index');