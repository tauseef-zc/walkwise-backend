<?php

use App\Http\Controllers\V1\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\V1\Api\Auth\LoginController;
use App\Http\Controllers\V1\Api\Auth\LogoutController;
use App\Http\Controllers\V1\Api\Auth\RegisterController;
use App\Http\Controllers\V1\Api\Auth\ResetPasswordController;
use App\Http\Controllers\V1\Api\Auth\UserController;
use App\Http\Controllers\V1\Api\Auth\VerificationController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {

    // Auth routes
    Route::prefix('auth')->name('auth.')->group(function () {

        // Guest auth routes
        Route::middleware('guest')->group(function () {
            Route::post('login',LoginController::class)->name('login');
            Route::post('register', RegisterController::class)->name('register');
            Route::post('email/send-verification', [VerificationController::class, 'sendVerificationMail'])
                ->name('verification.send');
            Route::post('verify', [VerificationController::class, 'verifyUser'])->name('verify.user');
            Route::post('forgot-password', ForgotPasswordController::class)->name('forgot.password');
        });

        // Protected auth routes
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('user',UserController::class)->name('user');
            Route::get('logout',LogoutController::class)->name('logout');
            Route::put('reset-password',ResetPasswordController::class)->name('reset.password');
        });

    });

});
