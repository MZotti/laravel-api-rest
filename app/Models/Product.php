<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'slug', 'weigth', 'width', 'heigth', 'depth'
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
