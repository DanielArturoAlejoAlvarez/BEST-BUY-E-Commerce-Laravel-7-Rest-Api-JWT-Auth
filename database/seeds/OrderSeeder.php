<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Order;
use Faker\Generator as Faker;


class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
      $users = User::all();

      foreach ($users as $user) {
        for ($i=0; $i < rand(-1,5); $i++) {
          Order::create([
            'user_id' =>  $user->id
          ]);
        }
      }
    }
}
