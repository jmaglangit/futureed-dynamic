<?php namespace FutureEd\Services;

use FutureEd\Models\Repository\Question\QuestionRepositoryInterface;
use FutureEd\Models\Repository\QuestionTranslation\QuestionTranslationRepositoryInterface;
use Illuminate\Support\Facades\App;

class QuestionTranslationServices {

	protected $question_translation;

	protected $google_translate;

	protected $question;

	/**
	 * @param QuestionTranslationRepositoryInterface $questionTranslationRepositoryInterface
	 * @param GoogleTranslateServices $googleTranslateServices
	 * @param QuestionRepositoryInterface $questionRepositoryInterface
	 */
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
	 * Google translate question table
	 * @param $input
	 */
	public function googleTranslate($input) {

		//loop throughout every 1000 rows.
		$offset = 0;
		$limit = config('futureed.seeder_record_limit');
		$record_count = $this->question_translation->questionCount();

		$current_lang = App::getLocale();
		App::setLocale(config('translatable.fallback_locale'));


		for ($i = 0; $i <= ceil( $record_count/ $limit); $i++) {

			$question = $this->question_translation->getQuestions([], $limit, $offset);

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
						'question_id' => $record['id'],
						'string' => $translated_text
					];

					$this->question_translation->updatedTranslation($data, $input['target_lang'], $input['field']);

					//update translatable into 0
					$this->question->updateQuestion($record['id'], [
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