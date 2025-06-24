<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;

class SliderItems extends Model
{
    use HasFactory;

    protected $fillable = [
        "slider_id",
        "title",
        "description",
        "image",
        "btn_text",
        "btn_url",
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
