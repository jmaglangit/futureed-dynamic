<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/17/17
 * Time: 11:31 AM
 */

namespace FutureEd\Models\Repository\ModuleQuestionTemplate;


interface ModuleQuestionTemplateRepositoryInterface {

	public function getModuleQuestionTemplates($criteria=[],$limit=0,$offset=0);

	public function getModuleQuestionTemplate($id);

	public function addModuleQuestionTemplate($data);

	public function updateModuleQuestionTemplate($id,$data);

	public function deleteModuleQuestionTemplate($id);
}