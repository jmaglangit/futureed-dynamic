<?php namespace FutureEd\Console\Commands;

use FutureEd\Services\AnswerExplanationTranslationServices;
use FutureEd\Services\ModuleTranslationServices;
use FutureEd\Services\QuestionAnswerTranslationServices;
use FutureEd\Services\QuestionTranslationServices;
use FutureEd\Services\QuoteTranslationServices;
use Illuminate\Console\Command;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Symfony\Component\Console\Input\InputOption;

class GoogleTranslate extends Command implements SelfHandling, ShouldBeQueued {

	use InteractsWithQueue, SerializesModels;

	protected $name = 'fl:google-translate';

	protected $description = 'Use Google Translate';

	protected $module_translation_service;

	protected $question_translation_service;

	protected $question_answer_translation_service;

	protected $answer_explanation_translation_service;

	protected $quote_translation_service;

	/**
	 * @param ModuleTranslationServices $moduleTranslationServices
	 * @param QuestionTranslationServices $questionTranslationServices
	 * @param QuestionAnswerTranslationServices $questionAnswerTranslationServices
	 * @param AnswerExplanationTranslationServices $answerExplanationTranslationServices
	 * @param QuoteTranslationServices $quoteTranslationServices
	 * @internal param $target_lang
	 * @internal param $field
	 * @internal param $tagged
	 */
	public function __construct(
		ModuleTranslationServices $moduleTranslationServices,
		QuestionTranslationServices $questionTranslationServices,
		QuestionAnswerTranslationServices $questionAnswerTranslationServices,
		AnswerExplanationTranslationServices $answerExplanationTranslationServices,
		QuoteTranslationServices $quoteTranslationServices
	) {
		parent::__construct();
		$this->module_translation_service = $moduleTranslationServices;
		$this->question_translation_service = $questionTranslationServices;
		$this->question_answer_translation_service = $questionAnswerTranslationServices;
		$this->answer_explanation_translation_service = $answerExplanationTranslationServices;
		$this->quote_translation_service = $quoteTranslationServices;
	}

	protected function getOptions() {
		return [
			['model', 'm', InputOption::VALUE_REQUIRED, 'Model to be translated.'],
			['language', 'lang', InputOption::VALUE_REQUIRED, 'Target language to translate'],
			['field', 'f', InputOption::VALUE_REQUIRED, 'Model attribute to be translated'],
			['tagged', 'tag', InputOption::VALUE_REQUIRED, 'Model attribute to be translated'],
		];
	}

	/**
	 * @return bool
	 */
	public function fire() {

		$this->comment('Starting Future Lesson Google Translate...');

		//check if model exists
		$this->comment('Validating...' . $this->option('model'));

		if (!in_array($this->option('model'), config('futureed.translatable_models'))) {
			$this->comment('Model defined not on the list.');
			return false;
		}

		//process the translation
		$this->comment('Processing...' . $this->option('model'));

		$input = [
			'target_lang' => $this->option('language'),
			'field' => $this->option('field'),
			'tagged' => $this->option('tagged')
		];

		switch ($this->option('model')) {

			case config('futureed.translatable_models.module'):

				//call to translate modules
				$this->module_translation_service->googleTranslate($input);
				break;

			case config('futureed.translatable_models.question'):

				//call to translate questions
				$this->question_translation_service->googleTranslate($input);
				break;

			case config('futureed.translatable_models.question_answer'):

				//call to question answers
				$this->question_answer_translation_service->googleTranslate($input);
				break;

			case config('futureed.translatable_models.answer_explanation'):

				//call to answer explanation
				$this->answer_explanation_translation_service->googleTranslate($input);
				break;

			case config('futureed.translatable_models.quote'):

				//call to quotes
				$this->quote_translation_service->googleTranslate($input);
				break;

			default:
				break;
		}
	}

}
