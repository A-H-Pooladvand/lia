<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Product\V1\ProductController;

Route::group(['prefix' => 'v1', 'as' => 'v1.'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::post('register', RegisterController::class)->name('register');
        Route::post('login', LoginController::class)->name('login');

    });

    Route::group(['middleware' => 'auth:api'], function () {
        Route::group(['prefix' => 'products', 'as' => 'product.'], function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::post('/', [ProductController::class, 'store'])->name('store');
            Route::get('{id}', [ProductController::class, 'show'])->name('show');
            Route::put('{id}', [ProductController::class, 'update'])->name('update');
            Route::delete('{id}', [ProductController::class, 'destroy'])->name('destroy');
        });

        Route::post('logout', LogoutController::class)->name('logout');
    });
});
