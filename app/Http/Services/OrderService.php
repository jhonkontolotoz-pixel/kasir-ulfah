<?php

namespace App\Http\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Events\TransactionBeginning;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OrderService
{

    public static function CreateOrder(array $data)
    {

        self::isValidQuantity($data['products']);

        DB::transaction(function () use ($data) {

            $total_price = collect($data['products'])->reduce(function ($carry, $item) {
                $product = Product::find($item['id']);
                return $carry + ($product->price * $item['qty']);
            }, 0);

            $order = Order::create([...$data, 'total_price' => $total_price]);

            foreach ($data['products'] as $product) {
                $order->orderItems()->create([
                    'product_id' => $product['id'],
                    'quantity' => $product['qty'],
                ]);

                Product::find($product['id'])->decrement('quantity', $product['qty']);
            }
        });
    }


    public static function isValidQuantity(array $data)
    {
        foreach ($data as $product) {
            $pro = Product::find($product['id']);

            if ($pro->quantity < $product['qty']) {
                return failMessageResponse("{$pro->title} Quantity is not Valid");
            }
        }
    }
}
