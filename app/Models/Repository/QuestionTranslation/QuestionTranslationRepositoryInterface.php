<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 9/13/16
 * Time: 3:07 PM
 */

namespace FutureEd\Models\Repository\QuestionTranslation;


interface QuestionTranslationRepositoryInterface {

	public function generateInitialLanguageTranslation($locale);

	public function checkLanguageAvailability($locale);

	public function getLanguages();

	public function updatedTranslation($data,$target_lang,$field);

	public function getTranslatedAttributes();

	public function getCollection($criteria,$limit,$offset);

	public function count();
}