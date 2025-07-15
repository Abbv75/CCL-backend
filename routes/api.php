<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PartieController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TournoiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
});

Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('{id}', [UserController::class, 'show']);
    Route::post('/', [UserController::class, 'store']);
    Route::put('{id}', [UserController::class, 'update']);
    Route::delete('{id}', [UserController::class, 'destroy']);
    Route::get('me', [UserController::class, 'me']);
});

Route::prefix('roles')->group(function () {
    Route::get('/', [RoleController::class, 'index']);
});

Route::prefix('tournoi')->group(function () {
    Route::get('/', [TournoiController::class, 'index']);
    Route::get('{id}', [TournoiController::class, 'show']);
    Route::post('/', [TournoiController::class, 'store']);
    Route::put('{id}', [TournoiController::class, 'update']);
    Route::delete('{id}', [TournoiController::class, 'destroy']);
});

Route::prefix('status')->group(function () {
    Route::get('/', [StatusController::class, 'index']);
    Route::get('{id}', [StatusController::class, 'show']);
    Route::post('/', [StatusController::class, 'store']);
    Route::put('{id}', [StatusController::class, 'update']);
    Route::delete('{id}', [StatusController::class, 'destroy']);
});

Route::prefix('tournoi/{tournoi}/partie')->group(function () {
    Route::get('/', [PartieController::class, 'index']);
    Route::get('{id}', [PartieController::class, 'show']);
    Route::post('/', [PartieController::class, 'store']);
    Route::put('{id}', [PartieController::class, 'update']);
    Route::delete('{id}', [PartieController::class, 'destroy']);
});
