<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthLoginRequest;
use App\Http\Requests\Api\AuthRegisterRequest;
use App\Http\Resources\RegisterUserResource;
use App\Services\ApiResponse\ApiResponseFacade;
use App\Services\Auth\AuthService;
use OpenApi\Annotations as OA;
use function auth;

class AuthController extends Controller
{

    public function __construct(private AuthService $authService)
    {
    }
    /**
     * @OA\Post(
     *     tags={"Authentication"},
     *     path="/v1/auth/register",
     *     summary="Register user",
     *     description="Register a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="amirreza",
     *                     minLength=5
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     example="amir@example.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     format="password",
     *                     example="123456",
     *                     minLength=6
     *                 ),
     *                 @OA\Property(
     *                     property="password_confirmation",
     *                     type="string",
     *                     format="password",
     *                     example="123456",
     *                     minLength=6
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User has been registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="User has been registered successfully"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     format="date-time"
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     format="date-time"
     *                 ),
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=false
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Validation Error"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="email",
     *                     type="array",
     *                     @OA\Items(
     *                         type="string",
     *                         example="تکمیل گزینه ایمیل الزامی است"
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="array",
     *                     @OA\Items(
     *                         type="string",
     *                         example="تکمیل گزینه ایمیل الزامی است"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */

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
            ->withData(new RegisterUserResource($registrationResult['data']))
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
            ->withData([
                "token" => auth()->user()->createToken($request->userAgent())->plainTextToken,
            ])->withStatus(200)
            ->build()->response();

    }
}
