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

	public function updatedTranslation($data,$target_lang,$field);

	public function getModuleTranslations($locale);

	public function getTranslatedAttributes();

	public function getQuestions($criteria,$limit,$offset);

	public function questionCount();
}