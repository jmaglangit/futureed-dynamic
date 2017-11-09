<?php namespace FutureEd\Models\Repository\ModuleContent;


use FutureEd\Models\Core\Module;
use FutureEd\Models\Core\ModuleContent;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;


class ModuleContentRepository implements ModuleContentRepositoryInterface{
	use LoggerTrait;

	/**
	 * Return all of the Module Contents.
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function getModuleContents(){
		DB::beginTransaction();

		try{
			$response = ModuleContent::all();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Return Module Content by id.
	 * @param $id
	 * @return \Illuminate\Support\Collection|null|static
	 */
	public function getModuleContent($id){
		DB::beginTransaction();

		try{
			$response = ModuleContent::find($id);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get Module Content by content_id.
	 * @param $content_id
	 * @return mixed
	 */
	public function getModuleContentByTeachingContent($content_id){
		DB::beginTransaction();

		try{
			$response = ModuleContent::contentId($content_id)->get();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Add new Module Content.
	 * @param $data
	 * @return string|static
	 */
	public function addModuleContent($data){
		DB::beginTransaction();

		try{
			$response = ModuleContent::create($data);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Update specific Module Content.
	 * @param $id
	 * @param $data
	 * @return ModuleContentRepository|\Illuminate\Support\Collection|null|string|static
	 */
	public function updateModuleContent($id,$data){
		DB::beginTransaction();

		try{

			ModuleContent::id($id)
				->update($data);

			$response = $this->getModuleContent($id);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Update Module Content by content_id.
	 * @param $content_id
	 * @param $data
	 * @return ModuleContentRepository|\Illuminate\Support\Collection|null|string|static
	 */
	public function updateModuleContentByTeachingContent($content_id, $data){
		DB::beginTransaction();

		try{

			ModuleContent::contentId($content_id)
				->update($data);

			$response = $this->getModuleContent($content_id);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get number of row under module.
	 * @param $module_id
	 *
	 * @return ModuleContentRepository|\Illuminate\Support\Collection|null|string|static
	 */
	public function getModuleContentCount($module_id){
		DB::beginTransaction();

		try{
			$module_content = new ModuleContent();

			$module_content = $module_content->moduleId($module_id);

			$response = $module_content->get()->count();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get Module Content sequence number.
	 * @param $module_id
	 */
	public function getModuleContentSequenceNos($module_id){
		DB::beginTransaction();

		try{
			$response = ModuleContent::select('id','seq_no')
							->moduleId($module_id)
							->orderBySeqNo()
							->get();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get module content sequence no.
	 * @param $content_id
	 * @return mixed
	 */
	public function getModuleContentSequenceNo($content_id){
		DB::beginTransaction();

		try{
			$response = ModuleContent::select('id','seq_no','module_id')
							->contentId($content_id)
							->get();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get last sequence number.
	 * @param $module_id
	 * @return mixed
	 */
	public function getLastSequenceNo($module_id){
		DB::beginTransaction();

		try{
			$response = ModuleContent::moduleId($module_id)
							->orderBySeqNoDesc()
							->pluck('seq_no');

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Update sequence number.
	 * @param $sequence
	 */
	public function updateSequence($sequence){
		DB::beginTransaction();

		try {
			$data = $sequence;

			foreach ($data as $seq => $list) {

				ModuleContent::find($list->id)
					->update([
						'seq_no' => $list->seq_no
					]);
			}


		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return true;
	}

	/**
	 * Get Module contents.
	 * @param array $criteria
	 * @param $limit
	 * @param $offset
	 * @return array
	 */
	public function getModuleContentLists($criteria = [],$limit,$offset){
		DB::beginTransaction();

		try{
			$query = new ModuleContent();
			$query = $query->with('teachingContent');

			if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

				$count = $query->count();
			} else {
				if (count($criteria) > 0) {

					if(isset($criteria['module_id'])){
						$query = $query->moduleId($criteria['module_id']);
					}

					if(isset($criteria['teaching_status'])){
						$query = $query->teachingStatus($criteria['teaching_status']);
					}
				}

				$count = $query->count();

				if ($limit > 0 && $offset >= 0) {
					$query = $query->offset($offset)->limit($limit);
				}

			}

			$query = $query->orderBySeqNo();

			$response = ['total' => $count, 'records' => $query->get()->toArray()];

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get Points to finish the module.
	 * @param $id
	 */
	public function getModulePointsToFinish($id){
		DB::beginTransaction();

		try{
			$response = Module::whereId($id)->pluck('points_to_finish');

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Delete module content.
	 * @param $content_id
	 * @return mixed
	 */
	public function deleteModuleContentByContent($content_id){
		DB::beginTransaction();

		try{
			$response = ModuleContent::contentId($content_id)->delete();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

}