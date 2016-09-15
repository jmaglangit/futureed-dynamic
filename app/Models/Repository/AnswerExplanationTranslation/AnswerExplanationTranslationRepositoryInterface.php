<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 9/13/16
 * Time: 3:01 PM
 */

namespace FutureEd\Models\Repository\AnswerExplanationTranslation;


interface AnswerExplanationTranslationRepositoryInterface {

	public function generateInitialLanguageTranslation($locale);

	public function checkLanguageAvailability($locale);

	public function updatedTranslation($data,$target_lang,$field);

	public function getTranslatedAttributes();

	public function getAnswerExplanation($criteria,$limit,$offset);

	public function answerExplanationCount();
}