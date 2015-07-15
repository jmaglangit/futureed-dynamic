<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use Carbon\Carbon;

class MediaTypeTableSeeder extends Seeder
{
    public function run()
    {

		\DB::table('media_types')->truncate();
		\DB::table('media_types')->insert([
			[
				'name' => 'Video',
				'description' => 'Video url from vimeo',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'name' => 'Text',
				'description' => 'Text Content',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'name' => 'Text',
				'description' => 'Image Content',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
		]);
    }
}
