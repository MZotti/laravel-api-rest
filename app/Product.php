<?php

namespace App;

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
}
