<?php

namespace App\Services\Auth\Contracts\Exceptions;

use Exception;

class AuthException extends Exception
{
    private const ERROR_MESSAGE_TEMPLE = '[%s]';
    private const ERROR_MESSAGE_TEMPLE_WITH_EXCEPTION = '[%s] - (%s)';

    public function __construct(protected $error, protected $code = 400, array $payload = null)
    {
        $this->error = 'auth.error.' . $this->error;
        $e = $payload['e'] ?? null;

        parent::__construct(
            sprintf(
                $e === null ?
                    self::ERROR_MESSAGE_TEMPLE :
                    self::ERROR_MESSAGE_TEMPLE_WITH_EXCEPTION,
                $this->error,
                $e ?? (new Exception)->getMessage()
            ),
            $code,
            $e
        );
    }

    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        return $this->code < 500;
    }

    /**
     * Render the exception as an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response([
            'isSuccessful' => false,
            'error' => $this->error,
            'message' => __($this->error),
        ], $this->code);
    }
}
