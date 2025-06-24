<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;

class KeyValue extends Model
{
    protected $table = 'key_values';

    protected $fillable = [
        "key",
        "value",
    ];
}
