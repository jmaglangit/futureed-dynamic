<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Models\Repository\QuoteTranslation\QuoteTranslationRepositoryInterface;
use FutureEd\Http\Requests\Api\QuoteTranslationRequest;
use Illuminate\Support\Facades\Artisan;

class QuoteTranslationController extends ApiController {

	protected $quote_translation;

	/**
	 * @param QuoteTranslationRepositoryInterface $quoteTranslationRepositoryInterface
	 */
	public function __construct(
		QuoteTranslationRepositoryInterface $quoteTranslationRepositoryInterface
	){
		$this->quote_translation = $quoteTranslationRepositoryInterface;
	}

	/**
	 * @param $locale
	 * @return mixed
	 */
	public function generateNewLanguage($locale){

		//generate default language
		$this->quote_translation->generateInitialLanguageTranslation($locale);

		return $this->respondWithData(true);
	}

	/**
	 * @param $locale
	 * @return mixed
	 */
	public function checkLanguageAvailability($locale){

		return $this->respondWithData($this->quote_translation->checkLanguageAvailability($locale));
	}

	/**
	 * @return mixed
	 */
	public function getLanguageTranslation(){

		//get config languages
		$languages = config('translatable.locales');

		//parse through out the languages if available.
		$available_lang = [];

		foreach($languages as $lang){
			if($this->quote_translation->checkLanguageAvailability($lang)){
				array_push($available_lang,[
					'code' => $lang,
					'word' => trans('messages.' . $lang)
				]);
			}
		}

		return $this->respondWithData($available_lang);
	}

	/**
	 * @return mixed
	 */
	public function getTranslatedAttributes(){

		$fields = $this->quote_translation->getTranslatedAttributes();

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
	 * @param QuoteTranslationRequest $request
	 * @return mixed
	 */
	public function googleTranslate(QuoteTranslationRequest $request){

		//check if input has translate only flagged or all.
		$input = $request->only(
			'target_lang',
			'field',
			'tagged'
		);

		//Queue translation
		// -m quote --language {lang} -f {field} --tagged {tagged|boolean}
		Artisan::queue('fl:google-translate',[
			'--model' => config('futureed.translatable_models.quote'),
			'--language' => $input['target_lang'],
			'--field' => $input['field'],
			'--tagged' => $input['tagged']
		]);

		return $this->respondWithData(trans('messages.queue_trans_google'));
	}


}
