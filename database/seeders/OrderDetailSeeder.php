<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::all();
        $products = Product::all();

        foreach ($orders as $order) {
            foreach ($products as $product) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => rand(1, 10),
                    'price' => rand(1000, 10000),
                ]);
            }
        }
    }
}
