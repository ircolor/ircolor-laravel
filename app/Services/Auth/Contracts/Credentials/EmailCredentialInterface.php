<?php

namespace App\Services\Auth\Contracts\Credentials;

use App\Services\Auth\Contracts\AuthCredentialInterface;
use App\Services\Auth\Contracts\Credentials\Base\HasEmailInterface;
use App\Services\Auth\Contracts\Credentials\Base\HasOneTimePasswordInterface;
use App\Services\Auth\Contracts\Credentials\Base\HasPasswordInterface;

interface EmailCredentialInterface extends AuthCredentialInterface, HasEmailInterface, HasPasswordInterface, HasOneTimePasswordInterface
{
    //
}
