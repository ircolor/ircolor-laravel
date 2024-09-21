<?php

namespace App\Services\AuthResult;

class AuthResultBuilder
{
    private bool $success = true;
    private string $message;
    private mixed $data = null;

    public function setSuccess(bool $success): self
    {
        $this->success = $success;
        return $this;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function setData(mixed $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function build(): AuthResult
    {
        return new AuthResult($this->success, $this->message, $this->data);
    }
}
