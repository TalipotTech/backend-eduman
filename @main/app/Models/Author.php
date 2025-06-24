<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'salute_name',
        'titel_name',
        'first_name',
        'last_name',
        'slug',
        'designation',
        'institute',
        'email',
        'phone',
        'street_address',
        'city',
        'zip',
        'country',
        'teaser',
        'description',
        'promo_video_url',
        'logo_url',
        'banner_url',
        'website_url',
        'fb_url',
        'instagram_url',
        'twitter_url',
        'linkedin_url',
        'category',
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
     * This author belongs to many courses, and the relationship is defined by the course_authors
     * table, where the course_id is the foreign key and the author_id is the local key.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany collection of courses
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class,'course_authors', 'author_id');
    }
}
