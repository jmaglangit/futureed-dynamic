<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\QuestionTranslationRequest;
use FutureEd\Models\Repository\QuestionTranslation\QuestionTranslationRepositoryInterface;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\Artisan;

class QuestionTranslationController extends ApiController {

	protected $question_translation;

	use LoggerTrait;

	/**
	 * @param QuestionTranslationRepositoryInterface $questionTranslationRepositoryInterface
	 */
	public function __construct(
		QuestionTranslationRepositoryInterface $questionTranslationRepositoryInterface
	){
		$this->question_translation = $questionTranslationRepositoryInterface;
	}

	/**
	 * generate new language
	 * @param $locale
	 * @return mixed
	 */
	public function generateNewLanguage($locale){

		//generate default language
		$this->question_translation->generateInitialLanguageTranslation($locale);

		return $this->respondWithData(true);
	}

	/**
	 * @param $locale
	 * @return mixed
	 */
	public function checkLanguageAvailability($locale){

		return $this->respondWithData($this->question_translation->checkLanguageAvailability($locale));
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
			if($this->question_translation->checkLanguageAvailability($lang)){
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

		$fields = $this->question_translation->getTranslatedAttributes();

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
	 * @param QuestionTranslationRequest $request
	 * @return mixed
	 */
	public function googleTranslate(QuestionTranslationRequest $request){

		//check if input has translate only flagged or all.
		$input = $request->only(
			'target_lang',
			'field',
			'tagged'
		);

		//Queue translation
		// -m question --language {lang} -f {field} --tagged {tagged|boolean}
		Artisan::queue('fl:google-translate',[
			'--model' => config('futureed.translatable_models.question'),
			'--language' => $input['target_lang'],
			'--field' => $input['field'],
			'--tagged' => $input['tagged']
		]);

		return $this->respondWithData(trans('messages.queue_trans_google'));
	}

}
