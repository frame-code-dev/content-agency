<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Relations\HasMany;

class InstagramAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'instagram_account_id',
        'username',
        'name',
        'profile_picture_url',
        'access_token',
        'token_type',
        'token_expires_at',
        'followers_count',
        'follows_count',
        'media_count',
        'reach',
        'impressions',
        'engagement_rate',
        'profile_views',
        'is_live_api',
        'insights_data',
        'last_synced_at',
    ];

    protected $casts = [
        'access_token' => 'encrypted',
        'token_expires_at' => 'datetime',
        'is_live_api' => 'boolean',
        'insights_data' => 'array',
        'last_synced_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(InstagramPost::class);
    }

    public function isTokenExpired(): bool
    {
        return $this->token_expires_at && $this->token_expires_at->isPast();
    }
}
