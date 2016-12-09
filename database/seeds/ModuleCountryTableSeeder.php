<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class ModuleCountryTableSeeder extends Seeder
{
    public function run()
    {
        $reader = Reader::createFromPath( storage_path('seeders') . '/module_country.csv');

        $seeds = [];

        foreach($reader as $data ){
            array_push($seeds,[
                'module_id' => $data[1],
                'country_id' => $data[2],
                'grade_id' => $data[3],
                'seq_no' => $data[4],
                'updated_by' => 1,
                'created_by' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        DB::table('module_countries')->truncate();
        DB::table('module_countries')->insert($seeds);
    }
}
