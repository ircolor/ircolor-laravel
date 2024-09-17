<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ApiResponseService\ApiResponseFacade;
use App\Services\AuthService\AuthService;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $loginResult = $this->authService->loginWithGoogle();

        if (!$loginResult['success']) {
            return ApiResponseFacade::withSuccess($loginResult['success'])
                ->withMessage($loginResult['message'])
                ->withStatus(500)
                ->build()->response();
        }
        return ApiResponseFacade::withSuccess($loginResult['success'])
            ->withMessage($loginResult['message'])
            ->withStatus(200)
            ->build()->response();
    }
}
