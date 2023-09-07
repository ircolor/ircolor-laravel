<?php

namespace App\Services\Auth\Enums;

enum AuthProviderSignInMethod: string
{
    case PASSWORD = 'password';
    case LINK = 'link';
    case OAUTH = 'oauth';
    case ONE_TIME_PASSWORD = 'otp';
}
