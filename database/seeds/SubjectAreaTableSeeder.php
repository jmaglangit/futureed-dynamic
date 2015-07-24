<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use Carbon\Carbon;

class SubjectAreaTableSeeder extends Seeder
{
    public function run()
    {
        $seed = [
			[1,101,'addition','','Enabled'],
			[1,102,'algebra','','Enabled'],
			[1,103,'comparing','','Enabled'],
			[1,104,'consumer','','Enabled'],
			[1,105,'counting ','','Enabled'],
			[1,106,'decimals','','Enabled'],
			[1,107,'division','','Enabled'],
			[1,108,'estimation','','Enabled'],
			[1,109,'exponents','','Enabled'],
			[1,110,'fractions','','Enabled'],
			[1,111,'geometry','','Enabled'],
			[1,112,'Graphs','','Enabled'],
			[1,113,'logical','','Enabled'],
			[1,114,'measurement','','Enabled'],
			[1,115,'money','','Enabled'],
			[1,116,'multiplication','','Enabled'],
			[1,117,'numbers','','Enabled'],
			[1,118,'operations','','Enabled'],
			[1,119,'patterns','','Enabled'],
			[1,120,'probability','','Enabled'],
			[1,121,'ratios','','Enabled'],
			[1,122,'spatial','','Enabled'],
			[1,123,'subtraction','','Enabled'],
			[1,124,'time','','Enabled'],
			[1,125,'Values','','Enabled'],
			[2,201,'nouns','','Enabled'],
			[2,202,'pronouns','','Enabled'],
			[2,203,'adjectives and adverbs','','Enabled'],
			[2,204,'capitalization and punctuation','','Enabled'],
			[2,205,'figurative language','','Enabled'],
			[2,206,'grammar','','Enabled'],
			[2,207,'verbs','','Enabled'],
			[2,208,'sentences','','Enabled'],
			[2,209,'reference skills','','Enabled'],
			[2,210,'vocabulary','','Enabled'],
			[2,211,'word analysis','','Enabled'],
			[2,212,'Writing conventions and strategies','','Enabled'],
			[3,301,'Digital Etiquette','','Enabled'],
			[3,302,'Digital Communication','','Enabled'],
			[3,303,'Digital Safety & Security','','Enabled'],
			[3,304,'Digital Commerce','','Enabled'],
			[3,305,'Digital Access','','Enabled'],
			[3,306,'Digital Literacy','','Enabled'],
			[3,307,'Digital Rights & Responsibilities','','Enabled'],
		];

		\DB::table('subject_areas')->truncate();

		foreach($seed as $data){

			\DB::table('subject_areas')->insert([
				[
					'subject_id' => $data[0],
					'code' => $data[1],
					'name' => $data[2],
					'description' => $data[3],
					'status' => $data[4],
					'created_by' => 1,
					'updated_by' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				]
			]);
		}
    }
}
