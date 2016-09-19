<?php namespace FutureEd\Services;

use FutureEd\Models\Repository\AnswerExplanation\AnswerExplanationRepositoryInterface;
use FutureEd\Models\Repository\AnswerExplanationTranslation\AnswerExplanationTranslationRepositoryInterface;
use Illuminate\Support\Facades\App;

class AnswerExplanationTranslationServices {

	protected $answer_explanation_translation;

	protected $google_translate;

	protected $answer_explanation;

	/**
	 * @param AnswerExplanationTranslationRepositoryInterface $answerExplanationTranslationRepositoryInterface
	 * @param AnswerExplanationRepositoryInterface $answerExplanationRepositoryInterface
	 * @param GoogleTranslateServices $googleTranslateServices
	 */
	public function __construct(
		AnswerExplanationTranslationRepositoryInterface $answerExplanationTranslationRepositoryInterface,
		AnswerExplanationRepositoryInterface $answerExplanationRepositoryInterface,
		GoogleTranslateServices $googleTranslateServices
	){
		$this->answer_explanation_translation = $answerExplanationTranslationRepositoryInterface;
		$this->answer_explanation = $answerExplanationRepositoryInterface;
		$this->google_translate = $googleTranslateServices;

	}

	/**
	 * Google translate answer explanation table.
	 * @param $input
	 * @return mixed
	 */
	public function googleTranslate($input){

		//loop throughout every 1000 rows.
		$offset = 0;
		$limit = config('futureed.seeder_record_limit');
		$record_count = $this->answer_explanation_translation->answerExplanationCount();

		$current_lang = App::getLocale();
		App::setLocale(config('translatable.fallback_locale'));

		for($i=0; $i <= ceil($record_count/$limit);$i++){

			$question = $this->answer_explanation_translation->getAnswerExplanation([],$limit,$offset);

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

					$this->answer_explanation_translation->updatedTranslation($data,$input['target_lang'],$input['field']);

					//update translatable into 0
					$this->answer_explanation->updateAnswerExplanation($record['id'],[
						'translatable' => config('futureed.false')
					]);
				}
			}
		}

		//get back previous locale
		App::setLocale($current_lang);

		return $input;
	}
}