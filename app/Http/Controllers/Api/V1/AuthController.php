<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthRegisterRequest;
use App\Http\Resources\RegisterUserResource;
use App\Services\ApiResponseService\ApiResponseFacade;
use App\Services\AuthService\AuthService;

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
}
