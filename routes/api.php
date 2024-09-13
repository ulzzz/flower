<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);
Route::apiResource('products', ProductController::class);
Route::patch('users/{user}/status', [UserController::class, 'toggleStatus']);
Route::patch('products/{product}/status', [ProductController::class, 'toggleStatus']);
Route::apiResource('orders', OrderController::class);



Route::get('/test', function () {
    return response()->json(['message' => 'Hello World!']);
});
