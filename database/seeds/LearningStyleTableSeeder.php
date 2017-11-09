<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use Carbon\Carbon;

class LearningStyleTableSeeder extends Seeder
{
    public function run()
    {
		\DB::table('learning_styles')->truncate();
		\DB::table('learning_styles')->insert([
			[
				'ls_banding' => '1',
				'ls_ips_abbr' => 'AC',
				'ls_ips_name' => 'Abstract Conceptualization',
				'name' => 'Verbal',
				'description' => 'You prefer using words, both in speech and writing.',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'ls_banding' => '2',
				'ls_ips_abbr' => 'AE',
				'ls_ips_name' => 'Active Experimentation',
				'name' => 'Social',
				'description' => 'You prefer to learn in groups or with other people.',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'ls_banding' => '3',
				'ls_ips_abbr' => 'CE',
				'ls_ips_name' => 'Concrete Experience',
				'name' => 'Visual',
				'description' => 'You prefer using pictures, images, and spatial understanding.',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'ls_banding' => '4',
				'ls_ips_abbr' => 'RO',
				'ls_ips_name' => 'Reflective Observer',
				'name' => 'Verbal',
				'description' => 'You prefer using words, both in speech and writing.',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],			
		]);
    }
}
