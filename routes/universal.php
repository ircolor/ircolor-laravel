<?php

use App\Http\Controllers\Api\V1\ColorController;
use App\Http\Controllers\Api\V1\PaletteController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/v1'], function () {

    Route::apiResource('palettes', PaletteController::class)->only(['index', 'show']);

    Route::get('/color/hex/{hex}', [ColorController::class, 'show']);
});
