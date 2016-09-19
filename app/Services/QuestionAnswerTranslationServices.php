<?php namespace FutureEd\Services;

use FutureEd\Models\Repository\QuestionAnswer\QuestionAnswerRepositoryInterface;
use FutureEd\Models\Repository\QuestionAnswerTranslation\QuestionAnswerTranslationRepositoryInterface;
use Illuminate\Support\Facades\App;

class QuestionAnswerTranslationServices {

	protected $question_answer_translation;

	protected $google_translate;

	protected $question_answer;

	/**
	 * @param QuestionAnswerTranslationRepositoryInterface $questionAnswerTranslationRepositoryInterface
	 * @param GoogleTranslateServices $googleTranslateServices
	 * @param QuestionAnswerRepositoryInterface $questionAnswerRepositoryInterface
	 */
	public function __construct(
		QuestionAnswerTranslationRepositoryInterface $questionAnswerTranslationRepositoryInterface,
		GoogleTranslateServices $googleTranslateServices,
		QuestionAnswerRepositoryInterface $questionAnswerRepositoryInterface
	){
		$this->question_answer_translation = $questionAnswerTranslationRepositoryInterface;
		$this->google_translate = $googleTranslateServices;
		$this->question_answer = $questionAnswerRepositoryInterface;
	}

	/**
	 * Google translate questions answer table.
	 * @param $input
	 * @return mixed
	 */
	public function googleTranslate($input) {

		//loop throughout every 1000 rows.
		$offset = 0;
		$limit = config('futureed.seeder_record_limit');
		$record_count = $this->question_answer_translation->questionAnswerCount();

		$current_lang = App::getLocale();
		App::setLocale(config('translatable.fallback_locale'));

		for ($i = 0; $i <= ceil( $record_count/ $limit); $i++) {

			$question = $this->question_answer_translation->getQuestionsAnswer([], $limit, $offset);

			$offset += $limit;

			//parse to array and add translations to target_language
			foreach ($question['records'] as $record) {

				//check if translatable and tagged
				$translatable = 0;

				if ($input['tagged'] == config('futureed.true')
					&& $record['translatable'] == config('futureed.true')
				) {

					$translatable++;

				} elseif ($input['tagged'] == config('futureed.false')) {

					//if all are translatable
					$translatable++;
				}

				if ($translatable == config('futureed.true')) {

					//set target language
					$this->google_translate->setTarget($input['target_lang']);

					//get translation using google translate
					$translated_text = $this->google_translate->translate($record[$input['field']]);

					$data = [
						'question_answer_id' => $record['id'],
						'string' => $translated_text
					];

					$this->question_answer_translation->updatedTranslation($data, $input['target_lang'], $input['field']);

					//update translatable into 0
					$this->question_answer->updateQuestionAnswer($record['id'], [
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