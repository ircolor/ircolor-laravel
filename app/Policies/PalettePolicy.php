<?php

namespace App\Policies;

use App\Models\Palette;
use App\Models\User;

class PalettePolicy
{
    public function update(User $user, Palette $palette): bool
    {
        return $user->id == $palette->user_id;
    }

    public function destroy(User $user, Palette $palette): bool
    {
        return $user->id == $palette->user_id;
    }
}
