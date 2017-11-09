<?php namespace FutureEd\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ViewClearCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'fl:clear';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Clear cached files.';

	protected $file_system;
	protected $file;

	/**
	 * Create a new command instance.
	 *
	 * @param Filesystem $file_system
	 * @param File $file
	 */
	public function __construct(
		Filesystem $file_system,
		File $file
	){
		parent::__construct();

		$this->file_system = $file_system;
		$this->file = $file;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->comment('Clearing'. $this->option('cache') . ' cached...');

		switch ($this->option('cache')){

			case 'cache':
				$this->file_system->deleteDirectory(storage_path().'/framework/cache/',true);
				break;
			case 'sessions':
				$this->file_system->deleteDirectory(storage_path().'/framework/sessions/',true);
				break;
			case 'views':
				$this->file_system->deleteDirectory(storage_path().'/framework/views/',true);
				break;
			default:
				$this->comment('Cached folder not available.');
				break;
		}

		$this->comment('done.');

	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['cache', InputArgument::OPTIONAL, 'clear cache folder.'],
			['sessions', InputArgument::OPTIONAL, 'clear sessions folder.'],
			['view', InputArgument::OPTIONAL, 'clear view folder.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['cache', null, InputOption::VALUE_OPTIONAL, 'Clear cached folder containers.', null],
		];
	}

}
