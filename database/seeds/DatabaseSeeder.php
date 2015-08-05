<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('UsersTableSeeder');
		$this->call('StudentsTableSeeder');
		$this->call('SchoolsTableSeeder');
		$this->call('PasswordImagesTableSeeder');
		$this->call('CountriesSeeder');
		$this->call('AvatarsTableSeeder');
		$this->command->info('Seeded the countries!');
		$this->call('ClientTableSeeder');
		$this->call('GradeTableSeeder');
		$this->call('AdminTableSeeder');
		$this->call('ClassroomTableSeeder');
		$this->call('AgeGroupTableSeeder');
		$this->call('CountryGradesTableSeeder');
		$this->call('ModuleTableSeeder');
		$this->call('QuotesTableSeeder');
		$this->call('AvatarQuotesTableSeeder');
		$this->call('AvatarPosesTableSeeder');
		$this->call('AvatarWikisTableSeeder');
		$this->call('MediaTypeTableSeeder');
		$this->call('LearningStyleTableSeeder');
		$this->call('SubjectTableSeeder');
		$this->call('SubjectAreaTableSeeder');
		$this->call('ModuleGroupTableSeeder');
		$this->call('QuestionAnswerTableSeeder');
		$this->call('QuestionTableSeeder');
		$this->call('BadgesTableSeeder');
		$this->call('PointLevelTableSeeder');
		$this->call('EventTableSeeder');
		$this->call('ContentTableSeeder');
    }

}
