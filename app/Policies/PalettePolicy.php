<?php

namespace App\Policies;

use App\Models\Palette;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PalettePolicy
{

    public function update(User $user, Palette $palette): bool
    {
        return $user->id == $palette->user_id;
    }

}
