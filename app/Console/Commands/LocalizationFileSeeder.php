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
		if(($csvFileName = $this->option('csvFile')) != '' && ($langCode = $this->option('langCode')) != '' )
		{
			if($this->option('isErrorMessage'))
			{
				$this->errors_local($csvFileName, $langCode);
			}
			else
			{
				$this->messages_local($csvFileName, $langCode);
			}
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
			['langCode', null, InputOption::VALUE_REQUIRED, 'The Language Code', ''],
			['isErrorMessage', null, InputOption::VALUE_NONE, 'If lang file is for error messages']
		];
	}


	private function errors_local($CsvFileName, $LangCode)
	{
		$lang_id_reader = Reader::createFromPath(storage_path('seeders') . '/' . $CsvFileName);

		$lang_id_array = [];
		$index_counter = 0;

		$content = '<?php'.PHP_EOL.PHP_EOL;
		$content = $content.'use FutureEd\Services\ErrorMessageServices as Error;'.PHP_EOL.PHP_EOL;
		$content = $content.'return ['.PHP_EOL.PHP_EOL;

		$this->info('Retrieving Language File');

		foreach($lang_id_reader as $index => $value)
		{
			if($index != 0 && $index != 1 && $index != 2 && $value[0] != '')
			{
				if(isset($value[2]) && $value[2] != "") {
					$lang_id_array[$index_counter][0] = addslashes($value[0]);
					$lang_id_array[$index_counter][1] = addslashes($value[2]);
					$index_counter++;
				}
			}
		}

		$this->info('Generating File');

		foreach($lang_id_array as $index => $value)
		{
			if(strpos($value[0], "Error") == 0) {
				$content = $content."\t".$value[0].' => "'.$value[1].'",'.PHP_EOL;
			}
			else {
				$content = $content."\t".''.(int)$value[0].' => "'.$value[1].'",'.PHP_EOL;
			}
		}

		$content = $content.'];';

		Storage::disk('language_local')->put($LangCode."/".'errors.php', $content);
	}

	private function messages_local($CsvFileName, $LangCode)
	{
		$lang_id_reader = Reader::createFromPath(storage_path('seeders') . '/' . $CsvFileName);
		$text_var_reader = Reader::createFromPath(storage_path('seeders') . '/' . 'translation_variable_text.csv');

		$text_var_array = [];
		$lang_id_array = [];

		$content = '<?php'.PHP_EOL.PHP_EOL;
		$content = $content.'return ['.PHP_EOL.PHP_EOL;
		$this->info('Retrieving Language File');

		foreach($lang_id_reader as $index => $value)
		{
			if($index != 0 && $index != 1 && $value[0] != '')
			{
				if(isset($value[1])) {
					$lang_id_array[] = addslashes($value[0]);
					$lang_id_array[] = addslashes($value[1]);
				}
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
					$content = $content."\t".'"'.$text_var_array[$index-1].'" => "'.$lang_id_array[$numIndex+1].'",'.PHP_EOL;
				}
			}
		}

		$content = $content.PHP_EOL.'];';

		Storage::disk('language_local')->put($LangCode."/".'messages.php', $content);
	}

}
