<?php

namespace App\Repositories\Like;

use App\Models\Palette;
use App\Services\AuthResult\AuthResultBuilder;

class LikeRepository
{

    public function __construct(private AuthResultBuilder $authResultBuilder)
    {
    }


    public function like(Palette $palette)
    {
        $palette->like();

        return $this->authResultBuilder->setSuccess(true)->build();
    }
}
