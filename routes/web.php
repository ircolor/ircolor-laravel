<?php

use App\Http\Controllers\Api\V1\GoogleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'web'], function () {
    Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
    Route::get('redirect/google', [GoogleController::class, 'handleGoogleCallback']);
});
