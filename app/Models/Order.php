<?php

namespace App\Models;

use App\Casts\Price;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'code',
        'status',
        'total_price',
        'payment_method',
        'user_id',
        'customer_id',
    ];


    protected $casts = [
        'total_price' => Price::class,
        'created_at' => 'datetime:Y-m-d h:i a',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')
                ->withPivot('quantity')
                ->withTimestamps();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Boot method for the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Generate Code when creating a order
        static::creating(function ($order) {
            $order->code = $order->generateCode();
            $order->user_id = auth()->user()->id ?? 1;
        });

        static::created(function ($order) {
            //works on redis
            //Cache::tags(['orders'])->flush();
        });
    }

    /**
     * Generate a unique Code for the order.
     */
    public function generateCode()
    {
        // Example SKU format: ORDR-<Random String>-<ID/Name Prefix>
        $randomPart = strtoupper(Str::random(6)); // 6-character random string
        $namePart = strtoupper(substr(Str::random(6), 0, 3));
        return "ORDR-{$namePart}-{$randomPart}";
    }
}
