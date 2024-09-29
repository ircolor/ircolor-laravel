<?php

namespace App\Observers;

use App\Models\Collection;
use App\Models\User;

class UserObserver
{
    public function created(User $user): void
    {
        Collection::create([
            'name' => Collection::DEFAULT_COLLECTION_NAME,
            'user_id' => $user->id,
        ]);
    }
}
