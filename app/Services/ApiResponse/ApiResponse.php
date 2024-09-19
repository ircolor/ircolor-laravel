<?php

namespace App\Services\ApiResponse;

class ApiResponse
{
    private string $message;
    private mixed $data = null;
    private int $status = 200;
    private array $appends = [];
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

    public function setAppends(array $appends)
    {
        $this->appends = $appends;
    }

    public function response()
    {
        $body = [];
        !is_null($this->message) && $body['message'] = $this->message;
        !is_null($this->data) && $body['data'] = $this->data;
        !is_null($this->success) && $body['success'] = $this->success;
        $body = $body + $this->appends;
        return response()->json($body, $this->status);
    }
}
