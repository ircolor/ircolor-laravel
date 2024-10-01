<?php

use App\Http\Controllers\Api\V1\CollectionController;
use App\Http\Controllers\Api\V1\CollectionPaletteController;
use App\Http\Controllers\Api\V1\LikeController;
use App\Http\Controllers\Api\V1\PaletteController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/v1'], function () {

    Route::apiResource('palettes', PaletteController::class)->only(['store', 'update', 'destroy']);
    Route::get('/palettes/{palette}/like', [LikeController::class, 'like']);
    Route::delete('/palettes/{palette}/unlike', [LikeController::class, 'unLike']);

    Route::apiResource('collections', CollectionController::class)->except('show');

    Route::resource('collections.palettes', CollectionPaletteController::class)
        ->only(['store', 'destroy', 'index']);

});
