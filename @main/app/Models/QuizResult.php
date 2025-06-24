<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;

class QuizResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'quiz_id',
        'settings_data',
        'content_data',
    ];

    protected $table = 'quiz_results';

    /**
     * ======================================
     * Relationships
     * ======================================
     */

    /**
     * The user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The organization.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

}
