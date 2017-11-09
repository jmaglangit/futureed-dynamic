<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Laracasts\TestDummy\Factory as TestDummy;

class SubscriptionDaysTableSeeder extends Seeder
{

    public function run()
    {
        $seeder = [
            [30,'Enabled'],
            [90,'Enabled'],
            [365,'Enabled'],
        ];

        \DB::table('subscription_days')->truncate();

        foreach($seeder as $data){

            DB::table('subscription_days')->insert([
                'days' => $data[0],
                'status' => $data[1],
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        }


    }
}
