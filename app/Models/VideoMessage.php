<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'video_path',
        'video_url',
        'preview_image',
        'moderation_status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
