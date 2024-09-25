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

    public function destroy(User $user, Collection $collection)
    {
        return $user->id == $collection->user_id;
    }

    public function storePalette(User $user, Collection $collection)
    {
        return $user->id == $collection->user_id;
    }

    public function removePalette(User $user, Collection $collection)
    {
        return $user->id == $collection->user_id;
    }
}
