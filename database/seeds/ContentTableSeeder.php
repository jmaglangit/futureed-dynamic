<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use Carbon\Carbon;
use League\Csv\Reader;

class ContentTableSeeder extends Seeder
{
    public function run()
    {
		$reader = Reader::createFromPath('public/csv/content.csv');

		\DB::table('teaching_contents')->truncate();
		foreach($reader as $index => $row) {


			\DB::table('teaching_contents')->insert([
				[
					'module_id' => $row[1],
					'subject_id' => $row[2],
					'subject_area_id' =>$row[3],
					'code' => $row[4],
					'teaching_module' => $row[5],
					'description' => $row[6],
					'learning_style_id' => $row[7],
					'content_text' => $row[8],
					'content_url' => $row[9],
					'media_type_id' => $row[10],
					'original_image_name' => 'seed',
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				]
			]);
		}
    }
}
