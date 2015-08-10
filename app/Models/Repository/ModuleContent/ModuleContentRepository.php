<?php namespace FutureEd\Models\Repository\ModuleContent;


use FutureEd\Models\Core\Module;
use FutureEd\Models\Core\ModuleContent;
use League\Flysystem\Exception;

class ModuleContentRepository implements ModuleContentRepositoryInterface{

	/**
	 * Return all of the Module Contents.
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function getModuleContents(){

		return ModuleContent::all();
	}

	/**
	 * Return Module Content by id.
	 * @param $id
	 * @return \Illuminate\Support\Collection|null|static
	 */
	public function getModuleContent($id){

		return ModuleContent::find($id);
	}

	/**
	 * Get Module Content by content_id.
	 * @param $content_id
	 * @return mixed
	 */
	public function getModuleContentByTeachingContent($content_id){

		return ModuleContent::contentId($content_id)
			->get();
	}

	/**
	 * Add new Module Content.
	 * @param $data
	 * @return string|static
	 */
	public function addModuleContent($data){

		try {

			return ModuleContent::create($data);

		} catch (Exception $e) {

			return $e->getMessage();
		}
	}

	/**
	 * Update specific Module Content.
	 * @param $id
	 * @param $data
	 * @return ModuleContentRepository|\Illuminate\Support\Collection|null|string|static
	 */
	public function updateModuleContent($id,$data){

		try{

			ModuleContent::id($id)
				->update($data);

			return $this->getModuleContent($id);

		}catch (Exception $e){

			return $e->getMessage();
		}
	}

	/**
	 * Update Module Content by content_id.
	 * @param $content_id
	 * @param $data
	 * @return ModuleContentRepository|\Illuminate\Support\Collection|null|string|static
	 */
	public function updateModuleContentByTeachingContent($content_id, $data){

		try{

			ModuleContent::contentId($content_id)
				->update($data);

			return $this->getModuleContent($content_id);

		}catch (Exception $e){

			return $e->getMessage();
		}
	}

	/**
	 * Get number of row under module.
	 * @param $module_id
	 *
	 * @return ModuleContentRepository|\Illuminate\Support\Collection|null|string|static
	 */
	public function getModuleContentCount($module_id){

		$module_content = new ModuleContent();

		$module_content = $module_content->moduleId($module_id);

		$count = $module_content->get()->count();

		return $count;

	}

	/**
	 * Get Module Content sequence number.
	 * @param $module_id
	 */
	public function getModuleContentSequenceNos($module_id){

		return ModuleContent::select('id','seq_no')
			->moduleId($module_id)
			->orderBySeqNo()
			->get();
	}

	/**
	 * Get module content sequence no.
	 * @param $content_id
	 * @return mixed
	 */
	public function getModuleContentSequenceNo($content_id){

		return ModuleContent::select('id','seq_no','module_id')
			->contentId($content_id)
			->get();
	}

	/**
	 * Get last sequence number.
	 * @param $module_id
	 * @return mixed
	 */
	public function getLastSequenceNo($module_id){

		return ModuleContent::moduleId($module_id)
			->orderBySeqNoDesc()
			->pluck('seq_no');
	}

	/**
	 * Update sequence number.
	 * @param $sequence
	 */
	public function updateSequence($sequence){
		try {
			$data = $sequence;

			foreach ($data as $seq => $list) {

				ModuleContent::find($list->id)
					->update([
						'seq_no' => $list->seq_no
					]);
			}


		} catch (Exception $e) {

			return $e->getMessage();
		}

	}

	/**
	 * Get Module contents.
	 * @param array $criteria
	 * @param $limit
	 * @param $offset
	 * @return array
	 */
	public function getModuleContentLists($criteria = [],$limit,$offset){

		$query = new ModuleContent();
		$query = $query->with('teachingContent');



		if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

			$count = $query->count();
		} else {
			if (count($criteria) > 0) {


				if(isset($criteria['module_id'])){
					$query = $query->moduleId($criteria['module_id']);
				}
			}

			$count = $query->count();

			if ($limit > 0 && $offset >= 0) {
				$query = $query->offset($offset)->limit($limit);
			}

		}

		$query = $query->orderBySeqNo();

		return ['total' => $count, 'records' => $query->get()->toArray()];

	}

	/**
	 * Get Points to finish the module.
	 * @param $id
	 */
	public function getModulePointsToFinish($id){

		return Module::whereId($id)->pluck('points_to_finish');
	}

}