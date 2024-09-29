<?php

namespace App\Models;

use App\Traits\Collectionable;
use App\Traits\Likeable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Palette extends Model implements Viewable
{
    use Collectionable, HasFactory, InteractsWithViews, Likeable;

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
}
