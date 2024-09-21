<?php

namespace App\Services\AuthResult;

class AuthResult
{
    public function __construct(private bool $success, private string $message, private mixed $data = null)
    {
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getData(): mixed
    {
        return $this->data;
    }
}
