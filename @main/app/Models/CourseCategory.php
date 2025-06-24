<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;

class CourseCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'category_id',
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
     * The course type.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}