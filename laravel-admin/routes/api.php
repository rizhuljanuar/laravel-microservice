<?php

use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);

Route::group(['middleware' => 'auth:api'], function () {

    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);

    Route::get('chart', [\App\Http\Controllers\DashboardController::class, 'chart']);
    Route::get('user', [\App\Http\Controllers\UserController::class, 'user']);
    Route::get('users/info', [\App\Http\Controllers\UserController::class, 'updateInfo']);
    Route::get('users/password', [\App\Http\Controllers\UserController::class, 'updatePassword']);

    Route::post('upload', [\App\Http\Controllers\ImageController::class, 'upload']);

    Route::apiResource('users', \App\Http\Controllers\UserController::class);
    Route::apiResource('roles', \App\Http\Controllers\RoleController::class);
    Route::apiResource('products', \App\Http\Controllers\ProductController::class);

    Route::get('export', [\App\Http\Controllers\OrderController::class, 'export']);
    Route::apiResource('orders', \App\Http\Controllers\OrderController::class)->only('index', 'show');
    Route::apiResource('permissions', \App\Http\Controllers\PermissionController::class)->only('index');
});

