<?php namespace FutureEd\Services;

use FutureEd\Models\Repository\Question\QuestionRepositoryInterface;
use FutureEd\Models\Repository\QuestionTranslation\QuestionTranslationRepositoryInterface;
use FutureEd\Models\Traits\TranslationServiceTrait;

class QuestionTranslationServices {

	use TranslationServiceTrait;

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
		$this->model_translation = $questionTranslationRepositoryInterface;
		$this->google_translate = $googleTranslateServices;
		$this->model = $questionRepositoryInterface;
	}

	/**
	 * Update Question
	 * @param $model_id
	 */
	protected function updateModel($model_id){
		//update translatable into 0
		$this->model->updateQuestion($model_id, [
			'translatable' => config('futureed.false')
		]);
	}
}