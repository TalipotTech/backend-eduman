<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;

class CourseReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'user_id',
        'rating',
        'message',
    ];

    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $casts = [
        'status' => StatusEnum::class,
    ];

    /**
     * The course.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * The user.
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'user_id', 'user_id');
    }
}