<?php namespace FutureEd\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Input;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class TruncateCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'fl:truncate';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Truncate select databases by the application.';

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
		\DB::table('announcements')->truncate();
		\DB::table('help_requests')->truncate();
		\DB::table('help_request_answers')->truncate();
		\DB::table('tips')->truncate();
		\DB::table('student_ls_scores')->truncate();
		\DB::table('student_ls_answers')->truncate();
		\DB::table('student_badges')->truncate();
		\DB::table('student_modules')->truncate();
		\DB::table('student_module_answers')->truncate();
		\DB::table('student_points')->truncate();
		$this->comment('Future Lessons Truncate.');

	}

}
