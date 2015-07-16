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
				'name' => 'Visual',
				'description' => 'You prefer using pictures, images, and spatial understanding.',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'name' => 'Aural',
				'description' => 'You prefer using sound and music.',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'name' => 'Verbal',
				'description' => 'You prefer using words, both in speech and writing.',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'name' => 'Physical',
				'description' => 'You prefer using your body, hands and sense of touch.',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'name' => 'Logical',
				'description' => 'You prefer using logic, reasoning and systems.',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'name' => 'Social',
				'description' => 'You prefer to learn in groups or with other people.',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
			[
				'name' => 'Solitary',
				'description' => 'You prefer to work alone and use self-study.',
				'created_by' => 1,
				'updated_by' => 1,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			],
		]);
    }
}
