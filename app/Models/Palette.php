<?php

namespace App\Models;

use App\Traits\Collectionable;
use App\Traits\Likeable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Support\Period;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Palette extends Model implements Viewable
{
    use Collectionable, HasFactory, InteractsWithViews, Likeable;

    const COLLECTION_COEFFICIENT = 0.5;
    const LIKE_COEFFICIENT = 0.3;
    const VIEW_COEFFICIENT = 0.2;

    protected $fillable = ['colors', 'user_id'];

    protected $casts = ['colors' => 'array'];

    protected $appends = ['views'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function viewsCount(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => views($this)->unique()->count(),
        );
    }

    public function scopeOrderByLikes(Builder $query, $direction = 'desc')
    {
        return $query->withCount('likes')->orderBy('likes_count', $direction);
    }

    public function scopeOrderByCollections(Builder $query, $direction = 'desc')
    {
        return $query->withCount('collections')->orderBy('collections_count', $direction);
    }
}
