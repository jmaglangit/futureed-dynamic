<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 4/4/17
 * Time: 9:09 PM
 */

namespace FutureEd\Models\Repository\QuestionTemplateOperation;


interface QuestionTemplateOperationRepositoryInterface {

	public function getQuestionTemplateOperation($id);

	public function addQuestionTemplateOperation($data);

	public function editQuestionTemplateOperation($id,$data);

	public function deleteQuestionTemplateOperation($id);

	public function getOperationByData($data);
}