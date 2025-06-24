<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;

class Invoice extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'course_id',
        'title',
        'qty',
        'unit_price',
        'total_price',
        'discount',
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
     * The iser.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
