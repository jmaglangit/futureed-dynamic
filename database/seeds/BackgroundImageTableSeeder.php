<?php

use Illuminate\Database\Seeder;
use League\Csv\Reader;
use Carbon\Carbon;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class BackgroundImageTableSeeder extends Seeder
{
    public function run()
    {
        $reader = Reader::createFromPath(storage_path('seeders') . '/background_image.csv');

        \DB::table('questions')->truncate();
        foreach($reader as $index => $row){

            \DB::table('background_images')->insert([
                [
                    'name' => $row[0],
                    'filename' => $row[1],
                    'status' => config('futureed.enabled'),
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            ]);

        }

    }
}
