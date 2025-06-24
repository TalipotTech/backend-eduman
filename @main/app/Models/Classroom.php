<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'slug',
        'content_data',
        'settings_data',
        'category',
        'status'
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

    /**
     * The course.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
