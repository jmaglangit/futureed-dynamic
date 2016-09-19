<?php namespace FutureEd\Services;

use FutureEd\Models\Repository\Module\ModuleRepositoryInterface;
use FutureEd\Models\Repository\ModuleTranslation\ModuleTranslationRepositoryInterface;
use Illuminate\Support\Facades\App;

class ModuleTranslationServices {

	protected $module_translation;

	protected $google_translate;

	protected $module;

	/**
	 * @param ModuleTranslationRepositoryInterface $moduleTranslationRepositoryInterface
	 * @param ModuleRepositoryInterface $moduleRepositoryInterface
	 * @param GoogleTranslateServices $googleTranslateServices
	 */
	public function __construct(
		ModuleTranslationRepositoryInterface $moduleTranslationRepositoryInterface,
		ModuleRepositoryInterface $moduleRepositoryInterface,
		GoogleTranslateServices $googleTranslateServices
	){
		$this->module_translation = $moduleTranslationRepositoryInterface;
		$this->google_translate = $googleTranslateServices;
		$this->module = $moduleRepositoryInterface;
	}

	/**
	 * Google translate module table.
	 * @param $input
	 * @return bool
	 */
	public function googleTranslate($input) {

		//loop on every 1000 rows, or translate by batch
		$offset = 0;
		$limit = config('futureed.seeder_record_limit');
		$record_count = $this->module_translation->moduleCount();

		$current_lang = App::getLocale();

		App::setLocale(config('translatable.fallback_locale'));

		for ($i = 0; $i <= ceil($record_count / $limit); $i++) {

			$module = $this->module_translation->getModules([], $limit, $offset);
			$offset += $limit;

			//parse to array and add translations to target_language
			foreach ($module['records'] as $record) {

				//check if translatable and tagged
				$translatable = 0;
				if ($input['tagged'] == config('futureed.true')
					&& $record['translatable'] == config('futureed.true')
				) {

					$translatable++;

				} elseif ($input['tagged'] == config('futureed.false')) {

					//if all are translatable
					$translatable++;
				}

				if ($translatable == config('futureed.true')) {

					// set target language
					$this->google_translate->setTarget($input['target_lang']);

					// get translation using google translate.
					$translated_text = $this->google_translate->translate($record[$input['field']]);

					$data = [
						'module_id' => $record['id'],
						'string' => $translated_text
					];

					$this->module_translation->updatedTranslation($data, $input['target_lang'], $input['field']);

					//update translatable tag to 0 on module
					$this->module->updateModule($record['id'], [
						'translatable' => config('futureed.false')
					]);
				}
			}
		}

		//get back the previous locale
		App::setLocale($current_lang);

		return $input;
	}
}