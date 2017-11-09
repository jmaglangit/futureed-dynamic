<?php namespace FutureEd\Services;

use FutureEd\Models\Repository\Module\ModuleRepositoryInterface;
use FutureEd\Models\Repository\ModuleTranslation\ModuleTranslationRepositoryInterface;
use FutureEd\Models\Traits\TranslationServiceTrait;

class ModuleTranslationServices {

	use TranslationServiceTrait;

	/**
	 * @param ModuleTranslationRepositoryInterface $moduleTranslationRepositoryInterface
	 * @param ModuleRepositoryInterface $moduleRepositoryInterface
	 * @param GoogleTranslateServices $googleTranslateServices
	 */
	public function __construct(
		ModuleTranslationRepositoryInterface $moduleTranslationRepositoryInterface,
		ModuleRepositoryInterface $moduleRepositoryInterface,
		GoogleTranslateServices $googleTranslateServices
	){
		$this->model_translation = $moduleTranslationRepositoryInterface;
		$this->google_translate = $googleTranslateServices;
		$this->model = $moduleRepositoryInterface;
	}

	/**
	 * Update module record.
	 * @param $model_id
	 */
	protected function updateModel($model_id){

		//update translatable tag to 0 on module
		$this->model->updateModule($model_id, [
			'translatable' => config('futureed.false')
		]);
	}
}