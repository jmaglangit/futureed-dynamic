<?php namespace FutureEd\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use Symfony\Component\Console\Input\InputOption;

class LocalizationFileSeeder extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'lang:seed';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Seeder for language localization';

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
	public function fire()
	{
		if(($CsvFileName = $this->option('csvFile')) != '' && ($LangCode = $this->option('langCode')) != '')
		{
			$lang_id_reader = Reader::createFromPath(storage_path('seeders') . '/' . $CsvFileName);
			$text_var_reader = Reader::createFromPath(storage_path('seeders') . '/' . 'translation_variable_text.csv');

			$text_var_array = [];
			$lang_id_array = [];
			$final_array = [];

			$content = '<?php'."\n\r";
			$content = $content.'return ['."\n\r";
			$this->info('Retrieving Language File');

			foreach($lang_id_reader as $index => $value)
			{
				if($index != 0 && $index != 1 && $value[0] != '')
				{
					$lang_id_array[] = addslashes($value[0]);
					$lang_id_array[] = addslashes($value[1]);
				}
			}
			foreach($text_var_reader as $index => $value)
			{
				if($index != 0 && $index != 1 && $value[0] != '')
				{
					$text_var_array[] = addslashes($value[0]);
					$text_var_array[] = addslashes($value[1]);
				}
			}
			$this->info('Generating File');
			foreach($text_var_array as $index => $value)
			{
				if($value != '')
				{
					$numIndex = array_search($value, $lang_id_array);
					if(!empty($numIndex))
					{
						$content = $content."\t".'"'.$text_var_array[$index-1].'" => "'.$lang_id_array[$numIndex+1].'",'."\n\r";
					}
				}
			}

			$content = $content.'];';

			Storage::disk('language_local')->put($LangCode."/".'messages.php', $content);
		}
		else
		{
			$this->info('One or more options is empty');
		}
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['csvFile', null, InputOption::VALUE_REQUIRED, 'The Language File in CSV Format', ''],
			['langCode', null, InputOption::VALUE_REQUIRED, 'The Language Code', '']
		];
	}

}
