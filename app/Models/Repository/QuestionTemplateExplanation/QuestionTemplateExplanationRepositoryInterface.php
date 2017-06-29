<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 6/28/17
 * Time: 11:07 AM
 */

namespace FutureEd\Models\Repository\QuestionTemplateExplanation;


interface QuestionTemplateExplanationRepositoryInterface {

	public function getQuestionTemplateExplanations($criteria=[],$limit=0,$offset=0);

	public function getQuestionTemplateExplanation($id);

	public function getQuestionTemplateExplanationByTemplateId($template_id);

	public function addQuestionTemplateExplanation($data);

	public function updateQuestionTemplateExplanation($id,$data);

	public function updateQuestionTemplateExplanationByTemplateId($template_id,$data);

	public function deleteQuestionTemplateExplanation($id);

}