<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'teaser',
        'description',
        'settings_data',
        'image_url',
        'video_url',
        'document_url',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'content_data' => 'array',
        'settings_data' => 'array',
        'status' => StatusEnum::class,
    ];
}
