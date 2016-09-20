<?php namespace FutureEd\Http\Controllers\Api\Traits;

use FutureEd\Http\Requests\Api\TranslatableRequest;
use Illuminate\Support\Facades\Artisan;

trait TranslationTrait {

	protected $model;

	protected $translatable_model;

	/**
	 * Check if language exist.
	 * @param $lang
	 * @return mixed
	 */
	public function checkLanguageAvailability($lang){

		return $this->respondWithData($this->model->checkLanguageAvailability($lang));
	}

	/**
	 * Get available languages
	 * @return mixed
	 */
	public function getLanguageTranslation(){

		//get config languages
		$languages = config('translatable.locales');

		//parse through out the languages if available.
		$available_lang = [];

		foreach($languages as $lang){
			if($this->model->checkLanguageAvailability($lang)){
				array_push($available_lang,[
					'code' => $lang,
					'word' => trans('messages.' . $lang)
				]);
			}
		}

		return $this->respondWithData($available_lang);
	}

	/**
	 * Initialize translation for the specific language.
	 * @param $locale
	 * @return mixed
	 */
	public function generateNewLanguage($locale){

		//generate default language
		$this->model->generateInitialLanguageTranslation($locale);

		return $this->respondWithData(true);
	}

	/**
	 * Get translation attributes.
	 * @return mixed
	 */
	public function getTranslatedAttributes(){

		$fields = $this->model->getTranslatedAttributes();

		// add manual translation indicators.
		$data = [];

		foreach($fields as $field){
			array_push($data,[
				'field' => $field,
				'auto' => 1
			]);
		}

		return $this->respondWithData($data);
	}

	/**
	 * googleTranslate
	 * @param TranslatableRequest $request
	 * @return
	 */
	public function googleTranslate(TranslatableRequest $request){

		//check if input has translate only flagged or all.
		$input = $request->only(
			'target_lang',
			'field',
			'tagged'
		);

		//Queue translation
		// -m question --language {lang} -f {field} --tagged {tagged|boolean}
		Artisan::queue('fl:google-translate',[
			'--model' => $this->translatable_model,
			'--language' => $input['target_lang'],
			'--field' => $input['field'],
			'--tagged' => $input['tagged']
		]);

		return $this->respondWithData(trans('messages.queue_trans_google'));
	}
}