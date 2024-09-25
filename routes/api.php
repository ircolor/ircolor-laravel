<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CollectionController;
use App\Http\Controllers\Api\V1\PaletteController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/v1'], function () {

    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::apiResource('palettes', PaletteController::class)->only(['store', 'update', 'destroy'])->middleware('auth:sanctum');
    Route::apiResource('palettes', PaletteController::class)->only(['index', 'show']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::apiResource('collections', CollectionController::class);
        Route::post('/collections/{collection}/{palette}/store', [CollectionController::class, 'storePalette']);
        Route::delete('/collections/{collection}/{palette}/remove', [CollectionController::class, 'removePalette']);
    });

});
