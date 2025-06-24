<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusEnum;

class Blog extends Model
{
    use HasFactory;

    /** @todo Select author_id from the dropdown */
    protected $fillable = [
        "title",
        "author_id",
        "teaser",
        "content",
        "image",
        "slug",
        "category_id",
        "status",
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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
