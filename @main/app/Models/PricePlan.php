<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;

class PricePlan extends Model
{
    use HasFactory;

    protected $fillable = [
        "type",
        "title",
        "money_sign",
        "amount",
        "duration",
        "details",
        "features",
        "badge_text",
        "is_highlighted",
        "status",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => StatusEnum::class,
    ];
}
