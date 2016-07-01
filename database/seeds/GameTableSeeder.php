<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class GameTableSeeder extends Seeder
{
    public function run()
    {
        $reader = Reader::createFromPath( storage_path('seeders') . '/games.csv');

        $seeds = [];
        foreach($reader as $index => $row) {

            array_push($seeds,[
                'code' => $row[1],
                'name' => $row[2],
                'game_url' => $row[3],
                'game_image' => $row[4],
                'points_price' => $row[5],
                'description' => $row[6],
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        DB::table('games')->truncate();

        DB::table('games')->insert($seeds);
    }
}
