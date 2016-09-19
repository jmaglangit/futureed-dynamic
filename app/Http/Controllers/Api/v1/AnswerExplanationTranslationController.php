<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\AnswerExplanationTranslationRequest;
use FutureEd\Models\Repository\AnswerExplanationTranslation\AnswerExplanationTranslationRepositoryInterface;
use Illuminate\Support\Facades\Artisan;

class AnswerExplanationTranslationController extends ApiController {

	protected $answer_explanation_translations;

	/**
	 * @param AnswerExplanationTranslationRepositoryInterface $answerExplanationTranslationRepositoryInterface
	 */
	public function __construct(
		AnswerExplanationTranslationRepositoryInterface $answerExplanationTranslationRepositoryInterface
	){
		$this->answer_explanation_translations = $answerExplanationTranslationRepositoryInterface;
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

		//Queue translation
		// -m answer_explanation --language {lang} -f {field} --tagged {tagged|boolean}
		Artisan::queue('fl:google-translate',[
			'--model' => config('futureed.translatable_models.answer_explanation'),
			'--language' => $input['target_lang'],
			'--field' => $input['field'],
			'--tagged' => $input['tagged']
		]);

		return $this->respondWithData(trans('messages.queue_trans_google'));
	}



}
