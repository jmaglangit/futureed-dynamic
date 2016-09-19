<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\QuestionAnswerTranslationRequest;
use FutureEd\Models\Repository\QuestionAnswer\QuestionAnswerRepositoryInterface;
use FutureEd\Models\Repository\QuestionAnswerTranslation\QuestionAnswerTranslationRepositoryInterface;
use FutureEd\Services\GoogleTranslateServices;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;

class QuestionAnswerTranslationController extends ApiController {

	protected $question_answer_translation;

	/**
	 * @param QuestionAnswerTranslationRepositoryInterface $questionAnswerTranslationRepositoryInterface
	 */
	public function __construct(
		QuestionAnswerTranslationRepositoryInterface $questionAnswerTranslationRepositoryInterface
	){
		$this->question_answer_translation = $questionAnswerTranslationRepositoryInterface;
	}

	/**
	 * Generate new language
	 * @param $locale
	 * @return mixed
	 */
	public function generateNewLanguage($locale){

		$this->question_answer_translation->generateInitialLanguageTranslation($locale);

		return $this->respondWithData(true);
	}

	/**
	 * @param $locale
	 * @return mixed
	 */
	public function checkLanguageAvailability($locale){

		return $this->respondWithData($this->question_answer_translation->checkLanguageAvailability($locale));
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
			if($this->question_answer_translation->checkLanguageAvailability($lang)){
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

		$fields = $this->question_answer_translation->getTranslatedAttributes();

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
	 * @param QuestionAnswerTranslationRequest $request
	 * @return mixed
	 */
	public function googleTranslate(QuestionAnswerTranslationRequest $request){

		//check if input has translate only flagged or all.
		$input = $request->only(
			'target_lang',
			'field',
			'tagged'
		);

		//Queue translation
		// -m question_answer --language {lang} -f {field} --tagged {tagged|boolean}
		Artisan::queue('fl:google-translate',[
			'--model' => config('futureed.translatable_models.question_answer'),
			'--language' => $input['target_lang'],
			'--field' => $input['field'],
			'--tagged' => $input['tagged']
		]);

		return $this->respondWithData(trans('messages.queue_trans_google'));
	}
}
