<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RentalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('api/v1')->group(function() {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('products')->group(function() {
            Route::post('/{id}/purchase', [ProductController::class, 'purchase']);
            Route::post('/{id}/rent', [ProductController::class, 'rent']);
            Route::get('/{id}/status', [ProductController::class, 'status']);
        });

        Route::prefix('rentals')->group(function() {
            Route::post('/{id}/extend', [RentalController::class, 'extend']);
        });
    });
});


