<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\QuestionTranslationRequest;
use FutureEd\Models\Repository\Question\QuestionRepositoryInterface;
use FutureEd\Models\Repository\QuestionTranslation\QuestionTranslationRepositoryInterface;
use FutureEd\Models\Traits\LoggerTrait;
use FutureEd\Services\GoogleTranslateServices;
use Illuminate\Support\Facades\App;
use SebastianBergmann\Environment\Console;


class QuestionTranslationController extends ApiController {

	protected $question_translation;

	protected $question;

	protected $google_translate;

	use LoggerTrait;

	public function __construct(
		QuestionTranslationRepositoryInterface $questionTranslationRepositoryInterface,
		GoogleTranslateServices $googleTranslateServices,
		QuestionRepositoryInterface $questionRepositoryInterface
	){
		$this->question_translation = $questionTranslationRepositoryInterface;
		$this->google_translate = $googleTranslateServices;
		$this->question = $questionRepositoryInterface;
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

		//loop throughout every 1000 rows.
		$offset = 0;
		$limit = config('futureed.seeder_record_limit');

		$current_lang = App::getLocale();

		for($i=0; $i <= ceil($this->question_translation->questionCount()/$limit);$i++){

			App::setLocale(config('translatable.fallback_locale'));

			$question = $this->question_translation->getQuestions([],$limit,$offset);

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
						'question_id' => $record['id'],
						'string' => $translated_text
					];

					$this->question_translation->updatedTranslation($data,$input['target_lang'],$input['field']);

					//update translatable into 0
					$this->question->updateQuestion($record['id'],[
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
