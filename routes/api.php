<?php

use App\Http\Controllers\Api\V1\CollectionController;
use App\Http\Controllers\Api\V1\PaletteController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/v1'], function () {

    Route::apiResource('palettes', PaletteController::class)->only(['store', 'update', 'destroy']);

    Route::apiResource('collections', CollectionController::class);
    Route::post('/collections/{collection}/{palette}/store', [CollectionController::class, 'storePalette']);
    Route::delete('/collections/{collection}/{palette}/remove', [CollectionController::class, 'removePalette']);
    Route::get('/collections/{collection}/palettes/show', [CollectionController::class, 'getPalettes']);

});
