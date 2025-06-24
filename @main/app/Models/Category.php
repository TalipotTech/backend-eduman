<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;
use App\Enums\EntityTypeEnum;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'parent_id',
        "slug",
        'title',
        "image",
        'description',
        'type',
        "status",
    ];

    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $casts = [
        'status' => StatusEnum::class,
        'type' => EntityTypeEnum::class,
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class, "category_id", "id");
    }

    /**
     * The parent course type.
     */
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class,'course_categories', 'category_id');
    }

    public function categoryChields()
    {
        return $this->hasMany(Category::class,'parent_id','id');
    }
}
