<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/14/17
 * Time: 2:15 PM
 */

namespace FutureEd\Models\Repository\QuestionTemplate;


interface QuestionTemplateRepositoryInterface {

	public function getQuestionTemplates($criteria=[],$limit=0,$offset=0);

	public function getQuestionTemplate($id);

	public function addQuestionTemplate($data);

	public function updateQuestionTemplate($id,$data);

	public function deleteQuestionTemplate($id);

}