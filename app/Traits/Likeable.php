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

    public function unLike()
    {
        $this->likes()->where('likeable_id', $this->id)->first()->delete();
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function checkLikeExists()
    {
        return $this->likes()->where('user_id', auth()->id())->exists();
    }

}
