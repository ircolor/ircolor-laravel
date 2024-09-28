<?php

namespace App\Observers;

use App\Http\Controllers\Api\V1\CollectionController;
use App\Models\Collection;
use App\Models\User;

class UserObserver
{
    public function created(User $user): void
    {
        Collection::create([
            'name' => CollectionController::DEFAULT_COLLECTION_NAME,
            'user_id' => $user->id,
        ]);
    }
}
