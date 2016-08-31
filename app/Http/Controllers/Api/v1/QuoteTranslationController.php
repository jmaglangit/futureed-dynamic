<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Models\Repository\Quote\QuoteRepositoryInterface;
use FutureEd\Services\GoogleTranslateServices;
use FutureEd\Http\Requests\Api\QuoteTranslationRequest;

class QuoteTranslationController extends ApiController {

	protected $quote;

	protected $translate_services;

	public function __construct(
		GoogleTranslateServices $googleTranslateServices,
		QuoteRepositoryInterface $quoteRepositoryInterface
	){
		$this->translate_services = $googleTranslateServices;
		$this->quote = $quoteRepositoryInterface;
	}

	//TODO translate quote
	public function generateTranslation(QuoteTranslationRequest $request){

		$translate = $request->all();

		$this->translate_services->setTarget($translate['target']);

		//TODO loop throughout each record and translate.

		$translation = $this->translate_services->translate($translate['text']);

		return $this->respondWithData($translation);
	}


}
