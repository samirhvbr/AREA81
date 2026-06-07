<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsArticle extends Model
{
    protected $connection = 'pgsql_vector';

    protected $fillable = [
        'url',
        'title',
        'source',
        'excerpt',
        'content',
        'published_at',
        'status',
        'score',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'score'        => 'float',
    ];

    public function isEmbedded(): bool
    {
        return in_array($this->status, ['embeddado', 'resumido']);
    }

    public function scopeNovo($query)
    {
        return $query->where('status', 'novo');
    }

    public function scopeEmbeddado($query)
    {
        return $query->where('status', 'embeddado');
    }
}
