<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 4/4/17
 * Time: 9:06 PM
 */

namespace FutureEd\Models\Repository\QuestionGradeCondition;


interface QuestionGradeConditionRepositoryInterface {

	public function getQuestionGradeCondition($id);

	public function getGradeId($grade_id);

	public function addQuestionGradeCondition($data);

	public function editQuestionGradeCondition($id,$data);

	public function deleteQuestionGradeCondition($id);


}