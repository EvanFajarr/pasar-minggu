<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'url','price','is_available'];
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            if (empty($product->url)) {
                $product->url = Str::slug($product->name);
            }
        });
        
    }
    public function images()
    {
        return $this->belongsToMany(ImageProduct::class, 'product_image', 'product_id', 'image_product_id');
    }
}
