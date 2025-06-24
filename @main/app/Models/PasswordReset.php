<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PasswordReset
 *
 */
class PasswordReset extends Model
{
    /** @var string */
    protected $table = 'password_resets';
    /** @var bool */
    public $timestamps = false;
    /** @var bool */
    protected static $unguarded = true;
    /** @var array */
    protected $fillable = ['email', 'token', 'created_at'];
    /** @var array */
    protected $hidden = [];
}
