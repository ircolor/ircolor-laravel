<?php

namespace App\Services\ApiResponse;

class ApiResponseBuilder
{
    private ApiResponse $response;

    public function __construct()
    {
        $this->response = new ApiResponse;
    }

    public function withMessage(string $message): ApiResponseBuilder
    {
        $this->response->setMessage($message);

        return $this;
    }

    public function withData(mixed $data): ApiResponseBuilder
    {
        $this->response->setData($data);

        return $this;
    }

    public function withStatus(int $status): ApiResponseBuilder
    {
        $this->response->setStatus($status);

        return $this;
    }

    public function withSuccess(bool $state): ApiResponseBuilder
    {
        $this->response->setSuccess($state);

        return $this;
    }

    public function build(): ApiResponse
    {
        return $this->response;
    }
}
