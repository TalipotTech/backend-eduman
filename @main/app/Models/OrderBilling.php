<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;

class OrderBilling extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'price_plan_id',
        'qty',
        'total_price',
        'payment_method',
        'first_name',
        'last_name',
        'street_address',
        'city',
        'country',
        'zip',
        'email',
        'phone',
        'alt_first_name',
        'alt_last_name',
        'alt_street_address',
        'alt_city',
        'alt_country',
        'alt_zip',
        'alt_email',
        'alt_phone',
        'start_at',
        'end_at',
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
     * The user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The price.
     */
    public function package()
    {
        return $this->belongsTo(PricePlan::class, 'price_plan_id');
    }


    
}
