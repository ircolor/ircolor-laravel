<?php

namespace App\Services\ApiResponse;

class ApiResponse
{
    private string $message;

    private mixed $data = null;

    private int $status = 200;

    private bool $success = true;

    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    public function setData(mixed $data)
    {
        $this->data = $data;
    }

    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    public function setSuccess(bool $state)
    {
        $this->success = $state;
    }

    public function response()
    {
        return response()->json([
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->data,
        ], $this->status);
    }
}
