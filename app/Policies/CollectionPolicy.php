<?php

namespace App\Policies;

use App\Models\Collection;
use App\Models\User;

class CollectionPolicy
{

    public function update(User $user, Collection $collection): bool
    {
        return $user->id == $collection->user_id;
    }
}
