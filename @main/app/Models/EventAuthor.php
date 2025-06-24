<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;

class EventAuthor extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 
        'author_id', 
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
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * The author.
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

}
