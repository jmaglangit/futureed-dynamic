<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Models\Repository\Quote\QuoteRepositoryInterface;
use FutureEd\Models\Repository\QuoteTranslation\QuoteTranslationRepositoryInterface;
use FutureEd\Services\GoogleTranslateServices;
use FutureEd\Http\Requests\Api\QuoteTranslationRequest;
use Illuminate\Support\Facades\App;

class QuoteTranslationController extends ApiController {

	protected $quote_translation;

	protected $quote;

	protected $google_translate;

	public function __construct(
		QuoteTranslationRepositoryInterface $quoteTranslationRepositoryInterface,
		QuoteRepositoryInterface $quoteRepositoryInterface,
		GoogleTranslateServices $googleTranslateServices
	){
		$this->quote_translation = $quoteTranslationRepositoryInterface;
		$this->quote = $quoteRepositoryInterface;
		$this->google_translate = $googleTranslateServices;
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

		//loop throughout every 1000 rows.
		$offset = 0;
		$limit = config('futureed.seeder_record_limit');

		$current_lang = App::getLocale();

		for($i=0; $i <= ceil($this->quote_translation->quoteCount()/$limit);$i++){

			App::setLocale(config('translatable.fallback_locale'));

			$quote = $this->quote_translation->getQuote([],$limit,$offset);

			$offset += $limit;

			//parse to array and add translations to target_language
			foreach($quote['records'] as $record){

				//check if translatable and tagged
				$translatable = 0;

				if($input['tagged'] == config('futureed.true')
					&& $record['translatable'] == config('futureed.true')){

					$translatable++;

				} elseif($input['tagged'] == config('futureed.false')){

					//if all are translatable
					$translatable++;
				}

				if($translatable == config('futureed.true')){

					//set target language
					$this->google_translate->setTarget($input['target_lang']);

					//get translation using google translate
					$translated_text = $this->google_translate->translate($record[$input['field']]);

					$data = [
						'quote_id' => $record['id'],
						'string' => $translated_text
					];

					$this->quote_translation->updatedTranslation($data,$input['target_lang'],$input['field']);

					//update translatable into 0
					$this->quote->updateQuote($record['id'],[
						'translatable' => config('futureed.false')
					]);
				}
			}
		}

		//get back previous locale
		App::setLocale($current_lang);

		return $this->respondWithData(trans('messages.success_trans_google'));
	}


}
