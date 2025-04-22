<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $order = Order::create([
                'user' => rand(1, 5),
                'total_price' => 0,
                'status' => 'pending',
            ]);

            $total = 0;

            for ($j = 1; $j <= rand(1, 5); $j++) {
                $quantity = rand(1, 3);
                $price = rand(10000, 50000);
                $subtotal = $quantity * $price;

                $order->items()->create([
                    'product_id' => rand(1, 10),
                    'quantity' => $quantity,
                    'price' => $price,
                    'image_path' => null, // bisa isi dummy seperti 'order_images/sample.jpg'
                ]);

                $total += $subtotal;
            }

            $order->update(['total_price' => $total]);
        }
    }
}
