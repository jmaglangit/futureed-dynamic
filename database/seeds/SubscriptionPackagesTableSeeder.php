<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use League\Csv\Reader;

class SubscriptionPackagesTableSeeder extends Seeder
{
    public function run()
    {
        $reader = Reader::createFromPath(storage_path('seeders') . '/subscription_packages.csv');

        \DB::table('subscription_packages')->truncate();

        foreach($reader as $data){

            DB::table('subscription_packages')->insert([
                'subject_id' => $data[1],
                'days_id' => $data[2],
                'subscription_id' => $data[3],
                'country_id' => $data[4],
                'price' => $data[5],
                'status' => $data[6],
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
