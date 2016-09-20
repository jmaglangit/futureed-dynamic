<?php namespace FutureEd\Services;

use FutureEd\Models\Repository\QuestionAnswer\QuestionAnswerRepositoryInterface;
use FutureEd\Models\Repository\QuestionAnswerTranslation\QuestionAnswerTranslationRepositoryInterface;
use FutureEd\Models\Traits\TranslationServiceTrait;

class QuestionAnswerTranslationServices {

	use TranslationServiceTrait;

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
		$this->model_translation = $questionAnswerTranslationRepositoryInterface;
		$this->google_translate = $googleTranslateServices;
		$this->model = $questionAnswerRepositoryInterface;
	}

	/**
	 * Update Question Answer
	 * @param $model_id
	 */
	protected function updateModel($model_id){
		//update translatable into 0
		$this->model->updateQuestionAnswer($model_id, [
			'translatable' => config('futureed.false')
		]);
	}
}