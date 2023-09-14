<?php

namespace App\Services\Auth\Enums;

enum AuthIdentifierType: string
{
    case EMAIL = 'email';
    case MOBILE = 'mobile';
}
