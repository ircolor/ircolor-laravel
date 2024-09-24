<?php

namespace App\Models;

use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Palette extends Model implements Viewable
{
    use HasFactory, InteractsWithViews;

    protected $fillable = ['colors', 'user_id'];

    protected $casts = ['colors' => 'array',];
    protected $appends = ['views'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getViewsAttribute()
    {
        return views($this)->unique()->count();
    }
}
