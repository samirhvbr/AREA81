<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscriber extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'status',
        'confirmation_token',
        'token_expires_at',
        'confirmed_at',
        'unsubscribed_at',
        'subscribe_ip',
    ];

    protected $casts = [
        'token_expires_at' => 'datetime',
        'confirmed_at'     => 'datetime',
        'unsubscribed_at'  => 'datetime',
    ];

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /** Token existe e ainda não expirou. */
    public function tokenIsValid(): bool
    {
        return $this->confirmation_token
            && $this->token_expires_at
            && $this->token_expires_at->isFuture();
    }

    /** Escopo: só inscritos confirmados (útil pra enviar a newsletter depois). */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }
}
