<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\QuestionAnswerTranslationRequest;
use FutureEd\Models\Repository\QuestionAnswer\QuestionAnswerRepositoryInterface;
use FutureEd\Models\Repository\QuestionAnswerTranslation\QuestionAnswerTranslationRepositoryInterface;
use FutureEd\Services\GoogleTranslateServices;
use Illuminate\Support\Facades\App;

class QuestionAnswerTranslationController extends ApiController {

	protected $question_answer_translation;

	protected $question_answer;

	protected $google_translate;

	public function __construct(
		QuestionAnswerRepositoryInterface $questionAnswerRepositoryInterface,
		GoogleTranslateServices $googleTranslateServices,
		QuestionAnswerTranslationRepositoryInterface $questionAnswerTranslationRepositoryInterface
	){
		$this->question_answer_translation = $questionAnswerTranslationRepositoryInterface;
		$this->question_answer = $questionAnswerRepositoryInterface;
		$this->google_translate = $googleTranslateServices;
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


	public function googleTranslate(QuestionAnswerTranslationRequest $request){

		//check if input has translate only flagged or all.
		$input = $request->only(
			'target_lang',
			'field',
			'tagged'
		);

		//loop throughout every 1000 rows.
		$offset = 0;
		$limit = 50;//config('futureed.seeder_record_limit');

		$current_lang = App::getLocale();

		for($i=0; $i <= ceil($this->question_answer_translation->questionAnswerCount()/$limit);$i++){

			App::setLocale(config('translatable.fallback_locale'));

			$question = $this->question_answer_translation->getQuestionsAnswer([],$limit,$offset);

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
						'question_answer_id' => $record['id'],
						'string' => $translated_text
					];

					$this->question_answer_translation->updatedTranslation($data,$input['target_lang'],$input['field']);

					//update translatable into 0
					$this->question_answer->updateQuestionAnswer($record['id'],[
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
