<?php

namespace App\Traits;

use App\Models\Like;
use App\Models\Palette;
use Illuminate\Database\Eloquent\Relations\MorphTo;

trait Likeable
{

    public function like()
    {
        $like = new Like(['user_id' => auth()->id()]);
        $this->likes()->save($like);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

}
