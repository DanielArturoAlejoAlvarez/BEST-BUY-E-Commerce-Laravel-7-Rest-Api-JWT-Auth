<?php

use Illuminate\Database\Seeder;
use App\Order;
use App\Product;
use App\OrderItem;
use Faker\Generator as Faker;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $orders = Order::all();
        $products = Product::all()->toArray();

        foreach ($orders as $order) {
          $used = [];

          for ($i=0; $i < rand(1,5); $i++) {
            $product = $faker->randomElement($products);

            if(!in_array($product["id"],$used)) {
              $id = $product["id"];
              $price = $product["price"];
              $quantity = $faker->numberBetween(1,3);

              OrderItem::create([
                'order_id'  =>  $order->id,
                'product_id'=>  $id,
                'quantity'  =>  $quantity,
                'price'     =>  $price
              ]);

              $used[] = $product["id"];
            }
          }
        }
    }
}
