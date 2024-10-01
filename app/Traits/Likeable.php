<?php

namespace App\Traits;

use App\Models\Like;

trait Likeable
{
    public function like()
    {
        $like = new Like(['user_id' => auth()->id()]);
        $this->likes()->save($like);
    }

    public function unLike()
    {
        $this->likes()->where([
            ['likeable_id', $this->id],
            ['user_id', auth()->id()],
        ])->delete();
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function isLiked()
    {
        return $this->likes()->where('user_id', auth()->id())->exists();
    }

    public function likesCount()
    {
        return $this->likes()->count();
    }
}
