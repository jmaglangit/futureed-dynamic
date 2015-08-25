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

		#$this->call('AdminTableSeeder');
		#$this->command->info('AdminTableSeeder seeded!');
		
		$this->call('AgeGroupTableSeeder');
		$this->command->info('AgeGroupTableSeeder seeded!');
		
		$this->call('AvatarPosesTableSeeder');
		$this->command->info('AvatarPosesTableSeeder seeded!');
		
		$this->call('AvatarQuotesTableSeeder');
		$this->command->info('AvatarQuotesTableSeeder seeded!');
		
		$this->call('AvatarWikisTableSeeder');
		$this->command->info('AvatarWikisTableSeeder seeded!');
		
		$this->call('AvatarsTableSeeder');
		$this->command->info('AvatarsTableSeeder seeded!');
		
		$this->call('BadgesTableSeeder');
		$this->command->info('BadgesTableSeeder seeded!');
		
		$this->call('ClassroomTableSeeder');
		$this->command->info('ClassroomTableSeeder seeded!');
		
		#$this->call('ClientTableSeeder');
		#$this->command->info('ClientTableSeeder seeded!');
		
		$this->call('ContentTableSeeder');
		$this->command->info('ContentTableSeeder seeded!');
		
		$this->call('CountriesSeeder');
		$this->command->info('CountriesSeeder seeded!');
		
		$this->call('CountryGradesTableSeeder');
		$this->command->info('CountryGradesTableSeeder seeded!');
		
		$this->call('EventTableSeeder');
		$this->command->info('EventTableSeeder seeded!');
		
		$this->call('GradeTableSeeder');
		$this->command->info('GradeTableSeeder seeded!');
		
		$this->call('LearningStyleTableSeeder');
		$this->command->info('LearningStyleTableSeeder seeded!');
		
		$this->call('MediaTypeTableSeeder');
		$this->command->info('MediaTypeTableSeeder seeded!');
		
		$this->call('ModuleContentTableSeeder');
		$this->command->info('ModuleContentTableSeeder seeded!');
		
		$this->call('ModuleGroupTableSeeder');
		$this->command->info('ModuleGroupTableSeeder seeded!');
		
		$this->call('ModuleTableSeeder');
		$this->command->info('ModuleTableSeeder seeded!');
		
		#$this->call('OrdersTableSeeder');
		#$this->command->info('OrdersTableSeeder seeded!');
		
		$this->call('PasswordImagesTableSeeder');
		$this->command->info('PasswordImagesTableSeeder seeded!');
		
		$this->call('PointLevelTableSeeder');
		$this->command->info('PointLevelTableSeeder seeded!');
		
		$this->call('QuestionAnswerTableSeeder');
		$this->command->info('QuestionAnswerTableSeeder seeded!');
		
		$this->call('QuestionTableSeeder');
		$this->command->info('QuestionTableSeeder seeded!');
		
		$this->call('QuotesTableSeeder');
		$this->command->info('QuotesTableSeeder seeded!');
		
		#$this->call('SchoolsTableSeeder');
		#$this->command->info('SchoolsTableSeeder seeded!');
		
		#$this->call('StudentsTableSeeder');
		#$this->command->info('StudentsTableSeeder seeded!');
		
		$this->call('SubjectAreaTableSeeder');
		$this->command->info('SubjectAreaTableSeeder seeded!');
		
		$this->call('SubjectTableSeeder');
		$this->command->info('SubjectTableSeeder seeded!');
		
		#$this->call('UsersTableSeeder');
		#$this->command->info('UsersTableSeeder seeded!');
		
		$this->command->info('OPTIONAL: Do individual seeding for the following: UsersTableSeeder, StudentsTableSeeder, SchoolsTableSeeder, OrdersTableSeeder, ClientTableSeeder, AdminTableSeeder');

    }

}
