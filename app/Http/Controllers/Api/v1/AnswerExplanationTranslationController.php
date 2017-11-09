<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Controllers\Api\Traits\TranslationTrait;
use FutureEd\Http\Requests;
use FutureEd\Models\Repository\AnswerExplanationTranslation\AnswerExplanationTranslationRepositoryInterface;

class AnswerExplanationTranslationController extends ApiController {

	use TranslationTrait;
	
	/**
	 * @param AnswerExplanationTranslationRepositoryInterface $answerExplanationTranslationRepositoryInterface
	 */
	public function __construct(
		AnswerExplanationTranslationRepositoryInterface $answerExplanationTranslationRepositoryInterface
	){
		$this->model = $answerExplanationTranslationRepositoryInterface;
		$this->translatable_model = config('futureed.translatable_models.answer_explanation');
	}
}
