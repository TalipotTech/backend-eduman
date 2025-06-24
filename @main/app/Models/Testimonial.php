<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "designation",
        "image",
        "title",
        "body",
        "rating",
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
}
