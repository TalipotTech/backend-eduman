<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'classroom_id',
        'course_id',
        'title',
        'slug',
        'settings_data',
        'content_data',
        'teaser',
        'description',
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
        'settings_data' => 'array',
        'status' => StatusEnum::class,
    ];

    /**
     * The Course.
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
