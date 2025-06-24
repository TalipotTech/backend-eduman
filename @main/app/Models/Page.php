<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "slug",
        "content",
        "status",
        "visibility_scope",
        "meta_title",
        "meta_description",
        "meta_image",
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
