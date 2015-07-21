<?php

namespace FutureEd\Models\Repository\Module;

use FutureEd\Models\Core\Module;
use League\Flysystem\Exception;


class ModuleRepository implements ModuleRepositoryInterface{

	public function addModule($data){

			try {

				$module = Module::create($data);

			} catch(Exception $e) {

				return $e->getMessage();

			}

			return $module;

	}

	public function getModules($criteria = array(), $limit = 0, $offset = 0){

		$module = new Module();

		$count = 0;

		$module = $module->with('subject','subjectArea','grade','studentModule');


		if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

			$count = $module->count();

		} else {


			if (count($criteria) > 0) {

				//check  subject_id
				if(isset($criteria['subject_id'])){

					$module = $module->subjectId($criteria['subject_id']);
				}

				//check grade_id
				if(isset($criteria['grade_id'])){

					$module = $module->gradeId($criteria['grade_id']);
				}

				//check module status
				if(isset($criteria['module_status'])){

					$module = $module->moduleStatus($criteria['module_status']);
				}

				//check relation to subject
				if(isset($criteria['subject'])){

					$module = $module->subjectName($criteria['subject']);
				}

				//check module name
				if(isset($criteria['name'])){

					$module = $module->name($criteria['name']);
				}

				//check relation to subject_area
				if(isset($criteria['area'])){

					$module = $module->subjectAreaName($criteria['area']);
				}

				//check age group
				if(isset($criteria['age_group_id'])){

					$module = $module->ageGroup($criteria['age_group_id']);
				}

			}

			$count = $module->count();

			if ($limit > 0 && $offset >= 0) {
				$module = $module->offset($offset)->limit($limit);
			}

		}

		return ['total' => $count, 'records' => $module->get()->toArray()];

	}

	public function viewModule($id){

		$module = new Module();

		$module = $module->with('subject','subjectarea','grade','content','question');
		$module = $module->find($id);
		return $module;

	}

	public function updateModule($id,$data){

		try{

			return Module::find($id)
				->update($data);

		} catch (Exception $e) {

			throw new Exception($e->getMessage());
		}

	}

	public function deleteModule($id){

		try {

			$module = Module::find($id);

			return !is_null($module) ? $module->delete() : false;

		} catch(Exception $e) {

			return $e->getMessage();

		}

	}

}