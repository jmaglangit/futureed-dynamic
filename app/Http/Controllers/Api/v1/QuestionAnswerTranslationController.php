<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Controllers\Api\Traits\TranslationTrait;
use FutureEd\Http\Requests;
use FutureEd\Models\Repository\QuestionAnswerTranslation\QuestionAnswerTranslationRepositoryInterface;

class QuestionAnswerTranslationController extends ApiController {

	use TranslationTrait;
	
	/**
	 * @param QuestionAnswerTranslationRepositoryInterface $questionAnswerTranslationRepositoryInterface
	 */
	public function __construct(
		QuestionAnswerTranslationRepositoryInterface $questionAnswerTranslationRepositoryInterface
	){
		$this->model = $questionAnswerTranslationRepositoryInterface;
		$this->translatable_model = config('futureed.translatable_models.question_answer');
	}

}
