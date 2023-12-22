<?php

use App\Http\Controllers\Api\Client\Auth\AuthController as ClientAuthController;
use App\Http\Controllers\Api\Client\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('client')->group(function () {
    Route::post('login', [ClientAuthController::class, 'login']);
    Route::post('register', [ClientAuthController::class, 'register']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [ClientAuthController::class, 'logout']);
        Route::post('profile/update', [UserController::class, 'updateProfile']);
        Route::post('password/change', [UserController::class, 'changePassword']);
    });
});

Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'user']);
