<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/17/17
 * Time: 11:04 AM
 */

namespace FutureEd\Models\Repository\AnswerExplanationTemplate;


interface AnswerExplanationTemplateRepositoryInterface {

	public function getAnswerExplanationTemplates($criteria=[],$limit=0,$offset=0);

	public function getAnswerExplanationTemplate($id);

	public function addAnswerExplanationTemplate($data);

	public function updateAnswerExplanationTemplate($id,$data);

	public function deleteAnswerExplanationTemplate($id);
}