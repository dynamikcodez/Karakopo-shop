<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = ['product_id', 'image_path', 'is_primary'];

    protected $appends = ['url'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getUrlAttribute(): string
    {
        if (empty($this->image_path)) {
            return asset('images/logo.png');
        }

        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            return $this->image_path;
        }

        if (str_starts_with($this->image_path, '/storage/') || str_starts_with($this->image_path, 'storage/')) {
            return asset(ltrim($this->image_path, '/'));
        }

        return asset('storage/' . ltrim($this->image_path, '/'));
    }
}
