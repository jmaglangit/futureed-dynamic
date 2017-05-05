<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/17/17
 * Time: 11:32 AM
 */

namespace FutureEd\Models\Repository\ModuleQuestionTemplate;


use FutureEd\Models\Core\ModuleQuestionTemplate;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class ModuleQuestionTemplateRepository implements ModuleQuestionTemplateRepositoryInterface {

	use LoggerTrait;

	/**
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 */
	public function getModuleQuestionTemplates($criteria=[],$limit=0,$offset=0){

		$module_question_template = new ModuleQuestionTemplate();

		//question_template_id
		if(isset($criteria['question_template_id'])){
			$module_question_template = $module_question_template->questionTemplateId($criteria['question_template_id']);
		}

		//template like
		if(isset($criteria['module_id'])){
			$module_question_template = $module_question_template->moduleId($criteria['module_id']);
		}

		//status
		if(isset($criteria['status'])){
			$module_question_template = $module_question_template->status($criteria['status']);
		}

		$count = $module_question_template->count();

		if ($offset >= 0 && $limit > 0) {

			$module_question_template = $module_question_template->skip($offset)->take($limit);
		}

		return [
			'total' => $count,
			'records' => $module_question_template->get()
		];
	}

	/**
	 * @param $id
	 * @return \Illuminate\Support\Collection|null|static
	 */
	public function getModuleQuestionTemplate($id){

		return ModuleQuestionTemplate::find($id);
	}

	/**
	 * @param $data
	 * @return bool|static
	 */
	public function addModuleQuestionTemplate($data){

		DB::beginTransaction();

		try{
			$response = ModuleQuestionTemplate::create($data);

		} catch(\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $id
	 * @param $data
	 * @return bool|int
	 */
	public function updateModuleQuestionTemplate($id,$data){

		DB::beginTransaction();
		try{

			$response = ModuleQuestionTemplate::find($id)->update($data);

		} catch(\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $id
	 * @return bool|null
	 */
	public function deleteModuleQuestionTemplate($id){

		DB::beginTransaction();

		try{

			$response = ModuleQuestionTemplate::find($id)->delete();

		} catch(\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $module_id
	 * @return mixed
	 */
	public function getTemplateByModule($module_id){

		return ModuleQuestionTemplate::whereModuleId($module_id)->with('questionCache')->get();

	}

}