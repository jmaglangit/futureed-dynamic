<?php namespace FutureEd\Http\Controllers\Api\Traits;

use FutureEd\Http\Requests\Api\TranslatableRequest;
use Illuminate\Support\Facades\Artisan;

trait TranslationTrait {

	protected $model;

	protected $translatable_model;

	protected $manual_translate = [];

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

		return $this->respondWithData($this->model->getLanguages()->map(function($value){
			return [
				'code' => $value->locale,
				'word' => trans('messages.' . $value->locale)
			];
		}));
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
				'auto' => (empty($this->manual_translate)) ? 1 :
					((in_array($field,$this->manual_translate)) ? 0 : 1)
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