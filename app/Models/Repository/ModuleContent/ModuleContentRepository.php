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

}