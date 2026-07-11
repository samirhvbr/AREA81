<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsDigest extends Model
{
    protected $fillable = [
        'digest_date',
        'content',
        'audio_path',
        'published_at',
        'sent_telegram',
        'sent_discord',
        'article_ids',
    ];

    protected $casts = [
        'digest_date'   => 'date',
        'published_at'  => 'datetime',
        'sent_telegram' => 'boolean',
        'sent_discord'  => 'boolean',
        'article_ids'   => 'array',
    ];

    public function isPublished(): bool
    {
        return $this->published_at !== null;
    }

    public function hasAudio(): bool
    {
        return $this->audio_path !== null;
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')->orderByDesc('digest_date');
    }
}
