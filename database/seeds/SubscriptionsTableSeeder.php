<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Laracasts\TestDummy\Factory as TestDummy;

class SubscriptionsTableSeeder extends Seeder
{
    public function run()
    {
        $seeder = [
            ['Basic','Basic','Enabled',0],
            ['Premium','Premium','Enabled',1],
            ['Trial','Trial','Enabled',0],
        ];

        \DB::table('subscription')->truncate();

        foreach($seeder as $data){

            \DB::table('subscription')->insert([
                'name' => $data[0],
                'description' => $data[1],
                'has_lsp' => $data[3],
                'status' => $data[2],
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
