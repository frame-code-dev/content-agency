<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'username',
        'followers_count',
        'engagement_rate',
        'avg_likes',
        'avg_comments',
        'gap_analysis_notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
