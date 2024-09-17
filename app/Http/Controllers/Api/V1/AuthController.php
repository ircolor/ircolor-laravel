<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthLoginRequest;
use App\Http\Requests\Api\AuthRegisterRequest;
use App\Services\ApiResponseService\ApiResponseFacade;
use App\Services\AuthService\AuthService;
use function auth;

class AuthController extends Controller
{

    public function __construct(private AuthService $authService)
    {
    }

    public function register(AuthRegisterRequest $request)
    {
        $registrationResult = $this->authService->register($request->toArray());

        if (!$registrationResult['success']) {
            return ApiResponseFacade::withSuccess($registrationResult['success'])
                ->withMessage($registrationResult['message'])
                ->withStatus(500)
                ->build()->response();
        }
        return ApiResponseFacade::withSuccess($registrationResult['success'])
            ->withMessage($registrationResult['message'])
            ->withData(resolve('RegisterUserResource', ['data' => $registrationResult['data']]))
            ->withStatus(200)
            ->build()->response();
    }

    public function login(AuthLoginRequest $request)
    {
        $loginResult = $this->authService->login($request->validated());

        if (!$loginResult['success']) {
            return ApiResponseFacade::withSuccess($loginResult['success'])
                ->withMessage($loginResult['message'])
                ->withStatus(401)
                ->build()->response();
        }
        return ApiResponseFacade::withSuccess($loginResult['success'])
            ->withMessage($loginResult['message'])
            ->withAppends([
                "token" => auth()->user()->createToken($request->userAgent())->plainTextToken,
            ])->withStatus(200)
            ->build()->response();

    }
}
