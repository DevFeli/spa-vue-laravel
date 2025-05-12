<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\ProductImagesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

// products
Route::middleware('auth:api')->group(function () {
    Route::get('/products', [ProductsController::class, 'index']);
    Route::post('/products', [ProductsController::class, 'create']);
    Route::put('/products', [ProductsController::class, 'update']);
    Route::post('/products/edit', [ProductsController::class, 'edit']);
});

// images
Route::middleware('auth:api')->group(function () {
    Route::delete('/image/{image}', [ProductImagesController::class, 'destroy']);
});

// users
Route::middleware('auth:api')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'create']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
    Route::put('/users', [UserController::class, 'edit']);
});

// logs
Route::middleware('auth:api')->group(function () {
    Route::get('/logs', [LogsController::class, 'index']);
});