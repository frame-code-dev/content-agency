<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstagramPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'instagram_account_id',
        'instagram_post_id',
        'caption',
        'media_type',
        'media_url',
        'permalink',
        'like_count',
        'comments_count',
        'posted_at',
    ];

    protected $casts = [
        'posted_at' => 'datetime',
        'like_count' => 'integer',
        'comments_count' => 'integer',
    ];

    public function instagramAccount(): BelongsTo
    {
        return $this->belongsTo(InstagramAccount::class);
    }
}
