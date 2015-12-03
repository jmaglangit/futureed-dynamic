<?php namespace FutureEd\Console\Commands;

use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Console\Command;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PhpSpec\Exception\Exception;
use Symfony\Component\Console\Input\InputOption;

class RebootFutureLessonCommand extends Command {

	Use LoggerTrait;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'fl:reboot';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Reboot Application';

	protected $seeder;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(
		Seeder $seeder
	) {
		parent::__construct();
		$this->seeder = $seeder;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire() {

		$this->comment('Starting Future Lesson reboot..');
		//list all database table.

		//initialize app data
		$tables = DB::select('show tables;');
		$db_name = "Tables_in_" . strtolower(DB::getConfig('database'));
		$except = [
			'migrations',
			'age_groups',
			'answer_explanations',
			'countries',
			'country_grades',
			'grades',
			'module_contents',
			'module_groups',
			'modules',
			'question_answers',
			'questions',
			'subject_areas',
			'subjects',
			'subscription',
			'teaching_contents'
		];


		if ($this->option('except') || $this->option('only')) {

			//delete by filter.
			$this->comment('deleting data...');
			//delete all data

			if ($this->option('except')) {
				//truncate all table except
				$except = array_merge($except, explode(",", $this->option('except')));

				foreach ($tables as $table) {
					if (!in_array($table->$db_name, $except)) {
						$this->truncateDataBaseTable($table->$db_name);
					}
				}

			} elseif ($this->option('only')) {
				//truncate only listed table
				$only = explode(",", $this->option('only'));

				foreach ($only as $table) {

					if (!in_array($table, $except)) {
						$this->truncateDataBaseTable($table);
					}
				}
			}
		} else {

			//Deleted all data.
			$this->comment('deleting all data...');

			//delete all table data
			foreach ($tables as $table) {
				if (!in_array($table->$db_name, $except)) {
					$this->truncateDataBaseTable($table->$db_name);
				}
			}

			$this->comment('running table seeders...');

			//Call Seeders
			$seeders = [
				'DefaultUserTableSeeder', //seed default admin
				//TODO 'AnswerExplanationsTableSeeder',
				//TODO 'AvatarAccessoriesTableSeeder',
				'AvatarPosesTableSeeder',
				'AvatarQuotesTableSeeder',
				'AvatarWikisTableSeeder',
				'AvatarsTableSeeder',
				'BadgesTableSeeder',
				'CountriesSeeder',
				'EventTableSeeder',
				'LearningStyleTableSeeder',
				//TODO 'LevelsTableSeeder',
				'MediaTypeTableSeeder',
				'PasswordImagesTableSeeder',
				'QuotesTableSeeder'
			];

			//iterate seeders
			foreach ($seeders as $seed) {

				$this->seedTables($seed);
			}


		}

		$this->comment('Reboot done...');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments() {
		return [
			//['all', InputArgument::OPTIONAL, 'An example argument.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions() {
		return [
			['except', null, InputOption::VALUE_OPTIONAL, 'Refresh except the table names.', null],
			['only', null, InputOption::VALUE_OPTIONAL, 'Refresh only the table listed.', null],

		];
	}

	/**
	 * Truncate Database
	 * @param $table
	 */
	public function truncateDataBaseTable($table) {

		DB::beginTransaction();
		try {

			DB::table($table)->truncate();
			$this->comment('Truncated ' . $table);


		} catch (\Exception $e) {

			DB::rollback();
			$this->errorLog('CONSOLE_LOG: ' . $e);
			$this->comment('Truncate failed ' . $table);
		}

		DB::commit();
		$this->alertLog('DATABASE_TABLE_TRUNCATE : ' . $table);

	}

	/**
	 * Seeding tables.
	 * @param $seeder
	 */
	public function seedTables($seeder) {

		DB::beginTransaction();
		try {

			$this->seeder->call($seeder);
			$this->comment($seeder . 'seeded...');

		} catch (\Exception $e) {

			DB::rollback();
			$this->errorLog('CONSOLE_LOG : ' . $e);
			$this->comment('Seeder failed ' . $seeder);
		}
		DB::commit();
	}

}
