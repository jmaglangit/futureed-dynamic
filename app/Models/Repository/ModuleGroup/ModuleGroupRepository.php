<?php namespace FutureEd\Models\Repository\ModuleGroup;

use FutureEd\Models\Core\ModuleGroup;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class ModuleGroupRepository implements ModuleGroupRepositoryInterface{
	use LoggerTrait;

	public function addModuleGroup($data){
		DB::beginTransaction();
		
		try {
			$response = ModuleGroup::create($data);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	public function getModuleGroups($criteria = array(), $limit = 0, $offset = 0){
		DB::beginTransaction();

		try{
			$moduleGroup = new ModuleGroup();

			$moduleGroup = $moduleGroup->with('ageGroup','module');
			$moduleGroup = $moduleGroup->orderByAge();
			

			if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

				$count = $moduleGroup->count();
			} else {
				if (count($criteria) > 0) {
					//check relation to subject
					if(isset($criteria['age_group'])){
						$moduleGroup = $moduleGroup->ageGroupId($criteria['age_group']);
					}
					//check module name
					if(isset($criteria['module_name'])){
						$moduleGroup = $moduleGroup->moduleName($criteria['module_name']);
					}

					//check module_id
					if(isset($criteria['module_id'])){
						$moduleGroup = $moduleGroup->moduleId($criteria['module_id']);
					}
				}

				$count = $moduleGroup->count();

				if ($limit > 0 && $offset >= 0) {
					$moduleGroup = $moduleGroup->offset($offset)->limit($limit);
				}

			}

			$response = ['total' => $count, 'records' => $moduleGroup->get()->toArray()];

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	public function getModuleGroup($id){
		DB::beginTransaction();

		try{
			$response = ModuleGroup::with('ageGroup','module')->find($id);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	public function updateModuleGroup($id,$data){
		DB::beginTransaction();

		try{
			$response = ModuleGroup::find($id)->update($data);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	public function deleteModuleGroup($id){
		DB::beginTransaction();

		try {
			$moduleGroup = ModuleGroup::find($id);

			$response = !is_null($moduleGroup) ? $moduleGroup->delete() : false;

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

	}


}