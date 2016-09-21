<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Controllers\Api\Traits\TranslationTrait;
use FutureEd\Http\Requests;
use FutureEd\Models\Repository\QuestionTranslation\QuestionTranslationRepositoryInterface;

class QuestionTranslationController extends ApiController {

	use TranslationTrait;
	
	/**
	 * @param QuestionTranslationRepositoryInterface $questionTranslationRepositoryInterface
	 */
	public function __construct(
		QuestionTranslationRepositoryInterface $questionTranslationRepositoryInterface
	){
		$this->model = $questionTranslationRepositoryInterface;
		$this->translatable_model = config('futureed.translatable_models.question');
	}

}
