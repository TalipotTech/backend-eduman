<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;
use App\Enums\UserRoles;

class EventAttendee extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 
        'user_id', 
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
     * The user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
