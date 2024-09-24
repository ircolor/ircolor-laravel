<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ApiResponse\ApiResponseFacade;
use App\Services\Auth\AuthService;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $loginResult = $this->authService->loginWithGoogle();

        if (! $loginResult->isSuccess()) {
            return ApiResponseFacade::withSuccess($loginResult->isSuccess())
                ->withMessage($loginResult->getMessage())
                ->withStatus(500)
                ->build()->response();
        }

        return ApiResponseFacade::withSuccess($loginResult->isSuccess())
            ->withMessage($loginResult->getMessage())
            ->withStatus(200)
            ->withData($loginResult->getData())
            ->build()->response();
    }
}
