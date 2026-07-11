<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug',
        'name',
    ];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }
}
