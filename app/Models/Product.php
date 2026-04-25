<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'product_name',
        'product_image',
        'product_price',
        'status',
        'product_description',
    ];

    // Your order items relationship
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    // Friend's cart items relationship
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }

    // Search scope
    public function scopeSearch($query, $term)
    {
        return $query->where('product_name', 'LIKE', "%{$term}%");
    }

    // Price range scope
    public function scopePriceRange($query, $min, $max)
    {
        if ($min) {
            $query->where('product_price', '>=', $min);
        }
        if ($max) {
            $query->where('product_price', '<=', $max);
        }
        return $query;
    }
}