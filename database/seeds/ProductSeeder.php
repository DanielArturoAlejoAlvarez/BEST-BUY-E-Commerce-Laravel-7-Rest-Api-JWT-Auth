<?php

use Illuminate\Database\Seeder;
use App\Image;
use App\Product;
use App\Category;
use Faker\Generator as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

      $categories = Category::all();

      foreach ($categories as $category) {
        for ($i=0; $i < rand(-1,10); $i++) {
          $code = $faker->uuid;
          $name = ucwords($faker->word);
          $excerpt = $faker->paragraph;
          $body = $faker->text;
          $price = $faker->randomFloat(2, 5, 100);
          $stock = $faker->numberBetween(100,1000);

          $products = Product::create([
              'category_id'   =>    $category->id,
              'code'          =>    $code,
              'name'          =>    $name,
              'excerpt'       =>    $excerpt,
              'body'          =>    $body,
              'price'         =>    $price,
              'stock'         =>    $stock
          ]);
        }
      }

      $products->each(function($product){
        $product->image()->save(factory(Image::class)->make(['url'=>$this->getPic(rand(1,500))]));
      });
    }

    private function getPic($max) {
      return 'https://picsum.photos/id/'.$max.'/1024/';
    }
}
