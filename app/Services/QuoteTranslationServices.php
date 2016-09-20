<?php namespace FutureEd\Services;


use FutureEd\Models\Repository\Quote\QuoteRepositoryInterface;
use FutureEd\Models\Repository\QuoteTranslation\QuoteTranslationRepositoryInterface;
use FutureEd\Models\Traits\TranslationServiceTrait;

class QuoteTranslationServices {

	use TranslationServiceTrait;

	/**
	 * @param QuoteTranslationRepositoryInterface $quoteTranslationRepositoryInterface
	 * @param QuoteRepositoryInterface $quoteRepositoryInterface
	 * @param GoogleTranslateServices $googleTranslateServices
	 */
	public function __construct(
		QuoteTranslationRepositoryInterface $quoteTranslationRepositoryInterface,
		QuoteRepositoryInterface $quoteRepositoryInterface,
		GoogleTranslateServices $googleTranslateServices
	) {
		$this->model_translation = $quoteTranslationRepositoryInterface;
		$this->model = $quoteRepositoryInterface;
		$this->google_translate = $googleTranslateServices;
	}

	/**
	 * Update Quote
	 * @param $model_id
	 */
	protected function updateModel($model_id){
		//update translatable into 0
		$this->model->updateQuote($model_id, [
			'translatable' => config('futureed.false')
		]);
	}
}