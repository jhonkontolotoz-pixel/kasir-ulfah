<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product_images;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Casts\Price;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'title',
        'sku',
        'price',
        'quantity',
        'description',
        'category_id',
    ];

    protected $casts = [
        'price' => Price::class,
        'created_at' => 'datetime:Y-m-d h:i a',
        'updated_at' => 'datetime:Y-m-d',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class, "category_id");
    }

    public function images()
    {
        return $this->hasMany(Product_images::class);
    }

    public function orders()
{
    return $this->belongsToMany(Order::class, 'order_products')
                ->withPivot('quantity')
                ->withTimestamps();
}

    /**
     * Boot method for the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Generate SKU when creating a product
        static::creating(function ($product) {
            $product->sku = $product->generateSKU();
        });
    }

    /**
     * Generate a unique SKU for the product.
     */
    public function generateSKU()
    {
        // Example SKU format: PROD-<Random String>-<ID/Name Prefix>
        $randomPart = strtoupper(Str::random(6)); // 6-character random string
        $namePart = strtoupper(substr($this->title, 0, 3)); // First 3 letters of the product name
        return "PROD-{$namePart}-{$randomPart}";
    }

}
