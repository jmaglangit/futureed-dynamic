<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 9/15/16
 * Time: 2:08 PM
 */

namespace FutureEd\Models\Repository\QuestionAnswerTranslation;


interface QuestionAnswerTranslationRepositoryInterface {

	public function generateInitialLanguageTranslation($locale);

	public function checkLanguageAvailability($locale);

	public function updatedTranslation($data,$target_lang,$field);

	public function getTranslatedAttributes();

	public function getCollection($criteria,$limit,$offset);

	public function count();
}