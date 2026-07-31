<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'topic',
        'concept',
        'caption',
        'tone',
        'media_type',
        'scheduled_at',
        'status',
        'spk_score',
        'priority_level',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
