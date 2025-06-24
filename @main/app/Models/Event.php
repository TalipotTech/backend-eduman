<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        "slug",
        'type',
        'available_seat',
        'teaser',
        'description',
        'image_url',
        'video_url',
        'document_url',
        'start_datetime',
        'end_datetime',
        'location',
        'join_url',
        'visible_from',
        'visible_to',
        'registration_start_at',
        'registration_end_at',
        'status',
    ];

    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'visible_from' => 'datetime',
        'visible_to' => 'datetime',
        'registration_start_at' => 'datetime',
        'registration_end_at' => 'datetime',
        'status' => StatusEnum::class,
    ];

    /**
     * The event category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class,'event_authors');
    }

    public function attendees()
    {
        return $this->belongsToMany(User::class,'event_attendees');
    }

}
