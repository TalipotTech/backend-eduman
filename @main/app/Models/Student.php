<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titel_name',
        'first_name',
        'last_name',
        'slug',
        'street_address',
        'city',
        'zip',
        'country',
        'teaser',
        'description',
        'image_url',
        'banner_url',
        'website_url',
        'instagram_url',
        'fb_url',
        'status',
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
     * The user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * This author belongs to many courses, and the relationship is defined by the course_users
     * table, where the course_id is the foreign key and the user_id is the local key.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany collection of courses
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_users', 'user_id');
    }
}
