<?php

namespace App\Services\Auth\Contracts\Credentials;

use App\Services\Auth\Contracts\AuthCredentialInterface;
use App\Services\Auth\Contracts\Credentials\Base\HasEmailInterface;

interface GoogleCredentialInterface extends AuthCredentialInterface, HasEmailInterface
{
    public function getIdToken(): string;
}
