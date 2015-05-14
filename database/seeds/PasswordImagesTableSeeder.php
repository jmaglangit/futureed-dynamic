<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class PasswordImagesTableSeeder extends Seeder {

    public function run()
    {
        $password_images = [];

        for($i=0;$i <= 64; $i++){

                $password_images = array_merge($password_images, [[
                    'name' => "img-pass-$i",
                    'password_image_file' => "img-pass-$i.jpg",
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ]]);
        }


        \DB::table('password_images')->truncate();
        \DB::table('password_images')->insert($password_images);
    }

}