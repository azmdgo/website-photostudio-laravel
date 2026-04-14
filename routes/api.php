<?php

use App\Http\Controllers\Api\Admin\UserController as AdminUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Admin API Routes (using web middleware to share session)
Route::middleware(['web'])->prefix('admin')->name('api.admin.')->group(function () {
    Route::middleware(['auth', 'admin'])->group(function () {
        // User Management API
        Route::apiResource('users', AdminUserController::class);
        Route::patch('users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
    });
});
