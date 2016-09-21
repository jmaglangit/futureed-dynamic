<?php namespace FutureEd\Models\Traits;


use Illuminate\Support\Facades\App;

trait TranslationServiceTrait {
	
	protected $model;
	
	protected $model_translation;
	
	protected $google_translate;

	/**
	 * Google Translate string to target language.
	 * @param $input
	 * @return mixed
	 */
	public function googleTranslate($input) {

		//loop on every 1000 rows, or translate by batch
		$offset = 0;
		$limit = config('futureed.seeder_record_limit');
		$record_count = $this->model_translation->count();

		$current_lang = App::getLocale();

		App::setLocale(config('translatable.fallback_locale'));

		for ($i = 0; $i <= ceil($record_count / $limit); $i++) {

			$module = $this->model_translation->getCollection([], $limit, $offset);
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
						'id' => $record['id'],
						'string' => $translated_text
					];

					$this->model_translation->updatedTranslation($data, $input['target_lang'], $input['field']);

					//update translatable tag to 0 on model
					$this->updateModel($record['id']);
				}
			}
		}

		//get back the previous locale
		App::setLocale($current_lang);

		return $input;
	}
}