<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageProduct extends Model
{
    use HasFactory;
    protected $fillable = ['image'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_image', 'image_product_id', 'product_id');
    }
}
