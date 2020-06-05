<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_images';
    protected $fillable = [
        'image_name', 'is_thumb'
    ];

    public function product()
    {
        return belongsTo(Product::class);
    }
}
