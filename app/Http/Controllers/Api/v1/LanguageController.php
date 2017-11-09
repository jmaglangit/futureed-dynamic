<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests\Api\LanguageRequest;
use FutureEd\Models\Repository\AnswerExplanationTranslation\AnswerExplanationTranslationRepositoryInterface;
use FutureEd\Models\Repository\ModuleTranslation\ModuleTranslationRepositoryInterface;
use FutureEd\Models\Repository\QuestionAnswerTranslation\QuestionAnswerTranslationRepositoryInterface;
use FutureEd\Models\Repository\QuestionTranslation\QuestionTranslationRepositoryInterface;
use FutureEd\Models\Repository\QuoteTranslation\QuoteTranslationRepositoryInterface;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class LanguageController extends ApiController {

	protected $module_translation;

	protected $question_translation;

	protected $question_answer_translations;

	protected $answer_explanation_translation;

	protected $quote_translations;

	public function __construct(
		ModuleTranslationRepositoryInterface $moduleTranslationRepositoryInterface,
		QuestionTranslationRepositoryInterface $questionTranslationRepositoryInterface,
		QuestionAnswerTranslationRepositoryInterface $questionAnswerTranslationRepositoryInterface,
		AnswerExplanationTranslationRepositoryInterface $answerExplanationTranslationRepositoryInterface,
		QuoteTranslationRepositoryInterface $quoteTranslationRepositoryInterface
	){
		$this->module_translation = $moduleTranslationRepositoryInterface;
		$this->question_translation = $questionTranslationRepositoryInterface;
		$this->question_answer_translations = $questionAnswerTranslationRepositoryInterface;
		$this->answer_explanation_translation = $answerExplanationTranslationRepositoryInterface;
		$this->quote_translations = $quoteTranslationRepositoryInterface;
	}

	/**
	 * @param $lang
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function setLanguage($lang)
	{
		if(!Session::has('appLanguage'))
		{
			Session::set('appLanguage', $lang);
		}
		else
		{
			Session::forget('appLanguage');
			Session::set('appLanguage', $lang);
		}

		Lang::setLocale(Session::get('appLanguage'));

		return back()->with('id', '');
	}

	/**
	 * Get all languages defined.
	 * @return mixed
	 */
	public function getLanguages(){

		//get config languages
		$languages = config('translatable.locales');

		//parse through out the languages if available.
		$available_lang = [];

		foreach($languages as $lang){
				array_push($available_lang,[
					'code' => $lang,
					'word' => trans('messages.' . $lang)
				]);
		}
		return $this->respondWithData($available_lang);
	}

	/**
	 * Initialize language throughout db tables.
	 * @param LanguageRequest $request
	 * @return mixed
	 * @internal param $locale
	 */
	public function initializeLanguage(LanguageRequest $request){

		$locale = $request->get('locale');

		//initialize module
		if(!$this->module_translation->checkLanguageAvailability($locale)){
			$this->module_translation->generateInitialLanguageTranslation($locale);
		}

		//initialize question
		if(!$this->question_translation->checkLanguageAvailability($locale)){
			$this->question_translation->generateInitialLanguageTranslation($locale);
		}

		//initialize question answer
		if(!$this->question_answer_translations->checkLanguageAvailability($locale)){
			$this->question_answer_translations->generateInitialLanguageTranslation($locale);
		}


		//initialize answer explanation
		if(!$this->answer_explanation_translation->checkLanguageAvailability($locale)){
			$this->answer_explanation_translation->generateInitialLanguageTranslation($locale);
		}

		// initialize quote
		if(!$this->quote_translations->checkLanguageAvailability($locale)){
			$this->quote_translations->generateInitialLanguageTranslation($locale);
		}


		return $this->respondWithData(trans('messages.success_initialize_language'));
	}
}
