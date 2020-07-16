<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Image;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(User::class,5)->create()->each(function($user) {
        $user->image()->save(factory(Image::class)->make(['url'=>$this->getAvatar(['men','women'],rand(1,99))]));
      });
    }

    private function getAvatar($arr,$max) {
      $arr_index = array_rand($arr);
      $index = $arr[$arr_index];
      return 'https://randomuser.me/api/portraits/'.$index.'/'.$max.'.jpg';
    }
}
