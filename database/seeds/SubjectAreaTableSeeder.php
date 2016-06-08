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
			[1,101,'Addition','','Enabled'],
			[1,102,'Algebra','','Enabled'],
			[1,103,'Comparing','','Enabled'],
			[1,104,'Consumer','','Enabled'],
			[1,105,'Counting ','','Enabled'],
			[1,106,'Decimals','','Enabled'],
			[1,107,'Division','','Enabled'],
			[1,108,'Estimation','','Enabled'],
			[1,109,'Exponents','','Enabled'],
			[1,110,'Fractions','','Enabled'],
			[1,111,'Geometry','','Enabled'],
			[1,112,'Graphs','','Enabled'],
			[1,113,'Logical','','Enabled'],
			[1,114,'Measurement','','Enabled'],
			[1,115,'Money','','Enabled'],
			[1,116,'Multiplication','','Enabled'],
			[1,117,'Numbers','','Enabled'],
			[1,118,'Operations','','Enabled'],
			[1,119,'Patterns','','Enabled'],
			[1,120,'Probability','','Enabled'],
			[1,121,'Ratios','','Enabled'],
			[1,122,'Spatial','','Enabled'],
			[1,123,'Subtraction','','Enabled'],
			[1,124,'Time','','Enabled'],
			[1,125,'Values','','Enabled'],
			[2,201,'Nouns','','Enabled'],
			[2,202,'Pronouns','','Enabled'],
			[2,203,'Adjectives And Adverbs','','Enabled'],
			[2,204,'Capitalization And Punctuation','','Enabled'],
			[2,205,'Figurative Language','','Enabled'],
			[2,206,'Grammar','','Enabled'],
			[2,207,'Verbs','','Enabled'],
			[2,208,'Sentences','','Enabled'],
			[2,209,'Reference Skills','','Enabled'],
			[2,210,'Vocabulary','','Enabled'],
			[2,211,'Word Analysis','','Enabled'],
			[2,212,'Writing Conventions And Strategies','','Enabled'],
			[3,213,'Vocabulary','','Enabled'],
			[3,214,'Vocab A-C','','Enabled'],
			[3,215,'Vocab D-H','','Enabled'],
			[3,216,'Vocab I-L','','Enabled'],
			[3,217,'Vocab M-P','','Enabled'],
			[3,218,'Vocab Q-T','','Enabled'],
			[3,219,'Vocab U-Z','','Enabled'],
	        [4,190,'Basic Movement','Basic coding for kids','Enabled']
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
