<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        "slug",
        'settings_data',
        'teaser',
        'more_info',
        'description',
        'image_url',
        'video_url',
        'document_url',
        'status',
        'category',
        'level',
        'credit',
        'duration',
        'price',
        'discount',
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
     * The review.
     */
    public function review_rating()
    {
        return $this->belongsTo(CourseReview::class, 'id');
    }

    public function search_category()
    {
        return $this->hasMany(CourseCategory::class, 'course_id', 'id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class,'course_categories', 'course_id', 'category_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'course_users');
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class,'course_authors');
    }

    public function enrolUsers()
    {
        return $this->belongsToMany(User::class,'course_users');
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'course_id', 'id');
    }

    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function courseOrganizations()
    {
        return $this->belongsToMany(Organization::class,'categories', 'course_id', 'category_id');
    }

}
