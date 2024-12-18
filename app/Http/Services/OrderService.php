<?php

namespace App\Http\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Events\TransactionBeginning;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OrderService{

    public static function CreateOrder(array $data)
    {

       self::isValidQuantity($data['products']);
       
       DB::transaction(function() use ($data){

        $total_price = Product::whereIn('id',collect($data['products'])->map(fn ($product) => $product['product_id']))->sum('price');

        $order = Order::create([...$data , 'total_price' => $total_price]);

        foreach ($data['products'] as $product) {
            $order->orderItems()->create([
                'product_id' => $product['product_id'],  
                'quantity' => $product['quantity'],  
            ]);

            Product::find($product['product_id'])->decrement('quantity', $product['quantity']);

    }

       });
      
}


public static function isValidQuantity(array $data)
    {

     
        foreach ($data as $product) {
            $pro = Product::find($product['product_id']);

            if($pro->quantity < $product['quantity'])
            {
                return failMessageResponse("{$pro->title} Quantity is not Valid");
            }
    }
}

}