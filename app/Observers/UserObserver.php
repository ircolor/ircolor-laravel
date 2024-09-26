<?php

namespace App\Observers;

use App\Models\Collection;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserObserver
{

    public function created(User $user): void
    {
        Collection::create([
            'name' => 'all',
            'user_id' => $user->id,
        ]);
    }
}
