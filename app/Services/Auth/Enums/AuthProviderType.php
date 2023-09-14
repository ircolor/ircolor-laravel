<?php

namespace App\Services\Auth\Enums;

enum AuthProviderType: string
{
    case INTERNAL = 'internal';
    case OAUTH = 'oauth';
}
