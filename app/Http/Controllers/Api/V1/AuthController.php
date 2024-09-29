<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\AuthLoginRequest;
use App\Http\Requests\Api\Auth\AuthRegisterRequest;
use App\Http\Resources\Auth\RegisterUserResource;
use App\Services\ApiResponse\ApiResponseFacade;
use App\Services\Auth\AuthService;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    /**
     * Get list of all palettes
     *
     * @unauthenticated
     */
    public function register(AuthRegisterRequest $request)
    {
        $registrationResult = $this->authService->register($request->input('name'), $request->input('email'), $request->input('password'));

        if (! $registrationResult->isSuccess()) {
            return ApiResponseFacade::withSuccess($registrationResult->isSuccess())
                ->withMessage($registrationResult->getMessage())
                ->withStatus(500)
                ->build()->response();
        }

        return ApiResponseFacade::withSuccess($registrationResult->isSuccess())
            ->withMessage($registrationResult->getMessage())
            ->withData(new RegisterUserResource($registrationResult->getData()))
            ->withStatus(200)
            ->build()->response();
    }

    /**
     * Get list of all palettes
     *
     * @unauthenticated
     */
    public function login(AuthLoginRequest $request)
    {
        $loginResult = $this->authService->login($request->input('email'), $request->input('password'));

        if (! $loginResult->isSuccess()) {
            return ApiResponseFacade::withSuccess($loginResult->isSuccess())
                ->withMessage($loginResult->getMessage())
                ->withStatus(401)
                ->build()->response();
        }

        return ApiResponseFacade::withSuccess($loginResult->isSuccess())
            ->withMessage($loginResult->getMessage())
            ->withData($loginResult->getData())
            ->withStatus(200)
            ->build()->response();
    }
}
