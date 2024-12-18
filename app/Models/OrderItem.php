<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'quantity', 'order_id', 'product_id'
    ];

    protected $table = 'order_products';

    /**
     * Get the order that owns the order item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product that is part of the order item.
     */
    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
