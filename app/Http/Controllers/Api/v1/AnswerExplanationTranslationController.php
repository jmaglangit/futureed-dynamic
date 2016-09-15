<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\AnswerExplanationTranslationRequest;
use FutureEd\Models\Repository\AnswerExplanation\AnswerExplanationRepositoryInterface;
use FutureEd\Models\Repository\AnswerExplanationTranslation\AnswerExplanationTranslationRepositoryInterface;
use FutureEd\Services\GoogleTranslateServices;
use Illuminate\Support\Facades\App;

class AnswerExplanationTranslationController extends ApiController {

	protected $answer_explanation_translations;

	protected $answer_explanation;

	protected $google_translate;

	public function __construct(
		AnswerExplanationTranslationRepositoryInterface $answerExplanationTranslationRepositoryInterface,
		AnswerExplanationRepositoryInterface $answerExplanationRepositoryInterface,
		GoogleTranslateServices $googleTranslateServices
	){
		$this->answer_explanation_translations = $answerExplanationTranslationRepositoryInterface;
		$this->answer_explanation = $answerExplanationRepositoryInterface;
		$this->google_translate = $googleTranslateServices;
	}

	/**
	 * @param $locale
	 * @return mixed
	 */
	public function generateNewLanguage($locale){

		$this->answer_explanation_translations->generateInitialLanguageTranslation($locale);

		return $this->respondWithData(true);
	}

	/**
	 * @param $locale
	 * @return mixed
	 */
	public function checkLanguageAvailability($locale){
		return $this->respondWithData($this->answer_explanation_translations->checkLanguageAvailability($locale));
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
			if($this->answer_explanation_translations->checkLanguageAvailability($lang)){
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

		$fields = $this->answer_explanation_translations->getTranslatedAttributes();

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
	 * @param AnswerExplanationTranslationRequest $request
	 * @return mixed
	 */
	public function googleTranslate(AnswerExplanationTranslationRequest $request){

		//check if input has translate only flagged or all.
		$input = $request->only(
			'target_lang',
			'field',
			'tagged'
		);

		//loop throughout every 1000 rows.
		$offset = 0;
		$limit = 5; //config('futureed.seeder_record_limit');

		$current_lang = App::getLocale();

		for($i=0; $i <= ceil($this->answer_explanation_translations->answerExplanationCount()/$limit);$i++){

			App::setLocale(config('translatable.fallback_locale'));

			$question = $this->answer_explanation_translations->getAnswerExplanation([],$limit,$offset);

			$offset += $limit;

			//parse to array and add translations to target_language
			foreach($question['records'] as $record){

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
						'answer_explanation_id' => $record['id'],
						'string' => $translated_text
					];

					$this->answer_explanation_translations->updatedTranslation($data,$input['target_lang'],$input['field']);

					//update translatable into 0
					$this->answer_explanation->updateAnswerExplanation($record['id'],[
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
