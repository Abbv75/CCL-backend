<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {

    Route::get('/', [UserController::class, 'index']);
    Route::get('{id}', [UserController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [UserController::class, 'store']);
        Route::put('{id}', [UserController::class, 'update']);
        Route::delete('{id}', [UserController::class, 'destroy']);
        Route::get('me', [UserController::class, 'me']);
    });
});

Route::prefix('/roles')->group(function () {
    Route::get('/', [RoleController::class, 'index']);
});
