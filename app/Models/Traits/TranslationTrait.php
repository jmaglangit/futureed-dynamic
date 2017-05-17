<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 11/18/16
 * Time: 10:03 AM
 */

namespace FutureEd\Models\Traits;

use FutureEd\Models\Core\AnswerExplanationTranslation;
use FutureEd\Models\Core\ModuleTranslation;
use FutureEd\Models\Core\QuestionAnswerTranslation;
use FutureEd\Models\Core\QuestionTranslation;
use Illuminate\Support\Facades\App;

trait TranslationTrait {

	/**
	 * Get Question Translation of the the column.
	 * @param $primary_key
	 * @param $value
	 * @param $column
	 * @return mixed
	 */
	public function getQuestionTranslation($primary_key,$value,$column){

		$translation = QuestionTranslation::where('question_id',$primary_key)
			->where('locale',App::getLocale())->pluck($column);

		return (!empty($translation)) ? $translation : $value;
	}

	/**
	 * Set Question Translation of the column.
	 * @param $primary_key
	 * @param $value
	 * @param $column
	 * @return mixed
	 */
	public function setQuestionTranslation($primary_key,$value,$column){

		$translation = QuestionTranslation::where('question_id',$primary_key)
			->where('locale',App::getLocale())->update([$column => $value]);

		return (!empty($translation)) ? $translation : $value;
	}

	/**
	 * Get Question Answer Translation of the column.
	 * @param $primary_key
	 * @param $value
	 * @param $column
	 */
	public function getQuestionAnswerTranslation($primary_key,$value,$column){

		$translation = QuestionAnswerTranslation::where('question_answer_id',$primary_key)
			->where('locale',App::getLocale())->pluck($column);

		return (!empty($translation)) ? $translation : $value;
	}

	/**
	 * Set Question Answer Translations of the column.
	 * @param $primary_key
	 * @param $value
	 * @param $column
	 * @return mixed
	 */
	public function setQuestionAnswerTranslation($primary_key,$value,$column){

		$translation = QuestionAnswerTranslation::where('question_answer_id',$primary_key)
			->where('locale',App::getLocale())->update([$column => $value]);

		return (!empty($translation)) ? $translation : $value;
	}

	/**
	 * Get Answer Explanation Translation of the column.
	 * @param $primary_key
	 * @param $value
	 * @param $column
	 * @return mixed
	 */
	public function getAnswerExplanationTranslation($primary_key,$value,$column){

		$translation = AnswerExplanationTranslation::where('answer_explanation_id',$primary_key)
			->where('locale',App::getLocale())->pluck($column);

		return (!empty($translation)) ? $translation : $value;
	}

	/**
	 * Set Answer Explanation Translation of the column.
	 * @param $primary_key
	 * @param $value
	 * @param $column
	 * @return mixed
	 */
	public function setAnswerExplanationTranslation($primary_key,$value,$column){

		$translation = AnswerExplanationTranslation::where('answer_explanation_id',$primary_key)
			->where('locale',App::getLocale())->update([$column => $value]);

		return (!empty($translation)) ? $translation : $value;

	}

	/**
	 * When new record is added.
	 * @param $values
	 * @return static
	 */
	public function addModuleTranslation($values){

		$values['locale'] = App::getLocale();

		$translation = ModuleTranslation::create($values);

		return (!empty($translation)) ? $translation : $values;
	}

	/**
	 * Get Module Translation of the column.
	 * @param $primary_key
	 * @param $value
	 * @param $column
	 * @return mixed
	 */
	public function getModuleTranslation($primary_key,$value,$column){

		$translation = ModuleTranslation::where('module_id',$primary_key)
			->where('locale',App::getLocale())->pluck($column);

		return (!empty($translation)) ? $translation : $value;
	}

	/**
	 * Update Module Translation of the column.
	 * @param $primary_key
	 * @param $value
	 * @param $column
	 * @return mixed
	 */
	public function setModuleTranslation($primary_key,$value){

		$translation = ModuleTranslation::where('module_id',$primary_key)
			->where('locale',App::getLocale())->update($value);

		return (!empty($translation)) ? $translation : $value;
	}

}