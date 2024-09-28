<?php

use App\Http\Controllers\Api\V1\CollectionController;
use App\Http\Controllers\Api\V1\LikeController;
use App\Http\Controllers\Api\V1\PaletteController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/v1'], function () {

    Route::apiResource('palettes', PaletteController::class)->only(['store', 'update', 'destroy']);
    Route::get('/palettes/{palette}/like', [LikeController::class, 'like']);
    Route::delete('/palettes/{palette}/unlike', [LikeController::class, 'unlike']);

    Route::apiResource('collections', CollectionController::class);
    Route::post('/collections/{collection}/{palette}/store', [CollectionController::class, 'storePalette']);
    Route::delete('/collections/{collection}/{palette}/remove', [CollectionController::class, 'removePalette']);
    Route::get('/collections/{collection}/palettes/show', [CollectionController::class, 'getPalettes']);

});
