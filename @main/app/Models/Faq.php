<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "slug",
        "description",
        "status",
        "category",
        "is_open",
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
