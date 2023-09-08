<?php

namespace App\Models;

use App\Services\Auth\Contracts\UserProviderInterface;
use App\Services\Auth\Traits\AuthProviderTrait;
use Illuminate\Database\Eloquent\Model;

class UserProvider extends Model implements UserProviderInterface
{
    use AuthProviderTrait;

    protected $casts = [
        'payload' => 'array',
        'verified_at' => 'immutable_datetime'
    ];
}
