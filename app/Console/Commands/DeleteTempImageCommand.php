<?php namespace FutureEd\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Filesystem\Filesystem;

class DeleteTempImageCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'fl:delete-temp-image';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Delete Temp Images Command description.';

	protected $file_system;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(Filesystem $file_system )
	{
		parent::__construct();

		$this->file_system = $file_system;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$this->file_system->deleteDirectory(config('futureed.content_image_path'));

		$this->file_system->deleteDirectory(config('futureed.answer_image_path'));

		$this->file_system->deleteDirectory(config('futureed.question_image_path'));

		$this->comment('Deleted all temp images.');

	}

}
