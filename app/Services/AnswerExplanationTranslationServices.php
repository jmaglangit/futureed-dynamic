<?php namespace FutureEd\Services;

use FutureEd\Models\Repository\AnswerExplanation\AnswerExplanationRepositoryInterface;
use FutureEd\Models\Repository\AnswerExplanationTranslation\AnswerExplanationTranslationRepositoryInterface;
use FutureEd\Models\Traits\TranslationServiceTrait;

class AnswerExplanationTranslationServices {

	use TranslationServiceTrait;

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
		$this->model_translation = $answerExplanationTranslationRepositoryInterface;
		$this->model = $answerExplanationRepositoryInterface;
		$this->google_translate = $googleTranslateServices;
	}

	/**
	 * Update Answer Explanation
	 * @param $model_id
	 */
	protected function updateModel($model_id){
		//update translatable into 0
		$this->model->updateAnswerExplanation($model_id,[
			'translatable' => config('futureed.false')
		]);
	}
}