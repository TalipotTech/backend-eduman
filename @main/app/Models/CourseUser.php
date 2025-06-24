<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;
use App\Enums\UserRoles;

class CourseUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 
        'user_id', 
        'role',
    ];

    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $casts = [
        'status' => StatusEnum::class,
        'role' => UserRoles::class,
    ];

    /**
     * The course.
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_users', 'course_id');
    }

    /**
     * The user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
