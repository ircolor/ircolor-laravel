<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Palette extends Model
{
    use HasFactory;

    protected $fillable = ['colors','user_id'];

    protected $casts = [
        'colors' => 'array',
    ];
}
