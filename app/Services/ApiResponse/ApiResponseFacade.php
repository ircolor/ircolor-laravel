<?php

namespace App\Services\ApiResponse;

use Illuminate\Support\Facades\Facade;

/**
 * @method static ApiResponseBuilder withMessage(string $message)
 * @method static ApiResponseBuilder withData(mixed $data)
 * @method static ApiResponseBuilder withStatus(int $status)
 * @method static ApiResponseBuilder withSuccess(bool $state)
 * @method static ApiResponse build()
 */
class ApiResponseFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'apiResponseFacade';
    }

}
