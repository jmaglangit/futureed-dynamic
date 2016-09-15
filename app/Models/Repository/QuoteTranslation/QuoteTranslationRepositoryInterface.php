<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 9/13/16
 * Time: 3:10 PM
 */

namespace FutureEd\Models\Repository\QuoteTranslation;


interface QuoteTranslationRepositoryInterface {

	public function generateInitialLanguageTranslation($locale);

	public function checkLanguageAvailability($locale);

	public function updatedTranslation($data,$target_lang,$field);

	public function getTranslatedAttributes();

	public function getQuote($criteria,$limit,$offset);

	public function quoteCount();
}