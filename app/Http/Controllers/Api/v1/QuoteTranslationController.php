<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Controllers\Api\Traits\TranslationTrait;
use FutureEd\Http\Requests;
use FutureEd\Models\Repository\QuoteTranslation\QuoteTranslationRepositoryInterface;

class QuoteTranslationController extends ApiController {

	use TranslationTrait;
	
	/**
	 * @param QuoteTranslationRepositoryInterface $quoteTranslationRepositoryInterface
	 */
	public function __construct(
		QuoteTranslationRepositoryInterface $quoteTranslationRepositoryInterface
	){
		$this->model = $quoteTranslationRepositoryInterface;
		$this->translatable_model = config('futureed.translatable_models.quote');
	}
}
