<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use Carbon\Carbon;

class BadgesTableSeeder extends Seeder
{
    public function run()
    {
		$seeder = [
			['Digital Literacy boy Grade 1','Male','digital_literacy/boys/digital_literacy_boys_grade1.png','1','1'],
			['Digital Literacy boy Grade 2','Male','digital_literacy/boys/digital_literacy_boys_grade2.png','1','1'],
			['Digital Literacy boy Grade 3','Male','digital_literacy/boys/digital_literacy_boys_grade3.png','1','1'],
			['Digital Literacy boy Grade 4','Male','digital_literacy/boys/digital_literacy_boys_grade4.png','1','1'],
			['Digital Literacy boy Grade 5','Male','digital_literacy/boys/digital_literacy_boys_grade5.png','1','1'],
			['Digital Literacy boy Grade 6','Male','digital_literacy/boys/digital_literacy_boys_grade6.png','1','1'],
			['Digital Literacy girl Grade 1','Female','digital_literacy/girls/digital_literacy_girls_grade1.png','1','1'],
			['Digital Literacy girl Grade 2','Female','digital_literacy/girls/digital_literacy_girls_grade2.png','1','1'],
			['Digital Literacy girl Grade 3','Female','digital_literacy/girls/digital_literacy_girls_grade3.png','1','1'],
			['Digital Literacy girl Grade 4','Female','digital_literacy/girls/digital_literacy_girls_grade4.png','1','1'],
			['Digital Literacy girl Grade 5','Female','digital_literacy/girls/digital_literacy_girls_grade5.png','1','1'],
			['Digital Literacy girl Grade 6','Female','digital_literacy/girls/digital_literacy_girls_grade6.png','1','1'],
			['English boy Grade 1','Male','english/boys/english_boys_grade1.png','1','1'],
			['English boy Grade 2','Male','english/boys/english_boys_grade2.png','1','1'],
			['English boy Grade 3','Male','english/boys/english_boys_grade3.png','1','1'],
			['English boy Grade 4','Male','english/boys/english_boys_grade4.png','1','1'],
			['English boy Grade 5','Male','english/boys/english_boys_grade5.png','1','1'],
			['English boy Grade 6','Male','english/boys/english_boys_grade6.png','1','1'],
			['English girl Grade 1','Female','english/girls/english_girls_grade1.png','1','1'],
			['English girl Grade 2','Female','english/girls/english_girls_grade2.png','1','1'],
			['English girl Grade 3','Female','english/girls/english_girls_grade3.png','1','1'],
			['English girl Grade 4','Female','english/girls/english_girls_grade4.png','1','1'],
			['English girl Grade 5','Female','english/girls/english_girls_grade5.png','1','1'],
			['English girl Grade 6','Female','english/girls/english_girls_grade6.png','1','1'],
			['Math boy Grade 1','Male','math/boys/math_badge_boy_grade_1.png','1','1'],
			['Math boy Grade 2','Male','math/boys/math_badge_boy_grade_2.png','1','1'],
			['Math boy Grade 3','Male','math/boys/math_badge_boy_grade_3.png','1','1'],
			['Math boy Grade 4','Male','math/boys/math_badge_boy_grade_4.png','1','1'],
			['Math boy Grade 5','Male','math/boys/math_badge_boy_grade_5.png','1','1'],
			['Math boy Grade 6','Male','math/boys/math_badge_boy_grade_6.png','1','1'],
			['Math girl Grade 1','Female','math/girls/math_badge_girl_grade_1.png','1','1'],
			['Math girl Grade 2','Female','math/girls/math_badge_girl_grade_2.png','1','1'],
			['Math girl Grade 3','Female','math/girls/math_badge_girl_grade_3.png','1','1'],
			['Math girl Grade 4','Female','math/girls/math_badge_girl_grade_4.png','1','1'],
			['Math girl Grade 5','Female','math/girls/math_badge_girl_grade_5.png','1','1'],
			['Math girl Grade 6','Female','math/girls/math_badge_girl_grade_6.png','1','1'],
		];

		\DB::table('badges')->truncate();

		foreach($seeder as $data){

			DB::table('badges')->insert([
				'name' => $data[0],
				'gender' => $data[1],
				'badge_image' => $data[2],
				'created_by' => $data[3],
				'updated_by' => $data[4],
				'description' => 'seed',
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			]);

		}

	}

}
