<?php

use App\Http\Controllers\Api\Client\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Client\Auth\LoginController;
use App\Http\Controllers\Api\Client\Auth\RegisterController;
use App\Http\Controllers\Api\Client\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Client\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('client')->group(function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', RegisterController::class);

    Route::prefix('password')->group(function () {
        Route::post('forgot', ForgotPasswordController::class);
        Route::post('reset', ResetPasswordController::class);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [LoginController::class, 'logout']);
        Route::post('profile/update', [UserController::class, 'updateProfile']);
        Route::post('password/change', [UserController::class, 'changePassword']);
    });
});

Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'user']);
