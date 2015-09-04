<?php namespace FutureEd\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DatabaseRefreshCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'fl:db-refresh';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Refresh selected databases.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		\DB::table('class_students')->truncate();
		\DB::table('classrooms')->truncate();
		\DB::table('invoices')->truncate();
		\DB::table('invoice_details')->truncate();
		\DB::table('orders')->truncate();
		\DB::table('student_modules')->truncate();
		\DB::table('student_module_answers')->truncate();
		\DB::table('student_points')->truncate();

		$this->comment('Future Lessons Database Refresh.');

	}
}
