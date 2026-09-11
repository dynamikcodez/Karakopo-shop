<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'sku', 'short_description', 
        'description', 'price', 'sale_price', 'stock', 'is_featured', 'is_published'
    ];

    protected $appends = ['image_url'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function getImageUrlAttribute(): string
    {
        $primary = $this->primaryImage 
            ?? $this->images()->where('is_primary', true)->first() 
            ?? $this->images()->first();

        if ($primary) {
            return $primary->url;
        }

        return asset('images/logo.png');
    }
}
