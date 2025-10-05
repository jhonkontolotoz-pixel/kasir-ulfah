<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        $this->call([
            UsersSeeder::class,
            CustomersSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            OrdersSeeder::class,
            OrdersProductsSeeder::class
        ]);

    }
}
