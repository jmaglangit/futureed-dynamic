<?php

namespace FutureEd\Models\Repository\MediaType;

use FutureEd\Models\Core\MediaType;
use FutureEd\Models\Traits\LoggerTrait;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\DB;


class MediaTypeRepository implements MediaTypeRepositoryInterface{
	use LoggerTrait;

	/**
	 * Gets list of MediaTypes.
	 * @param $criteria
	 * @param $limit
	 * @param $offset
	 * @return array
	 */
	public function getMediaTypes($criteria = array(), $limit = 0, $offset = 0){
		DB::beginTransaction();

		try{
			$media_type = new MediaType();

			$count = 0;

			if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {
				$count = $media_type->count();
				
			} else {
				if (count($criteria) > 0) {
					//check scope name
					if(isset($criteria['name'])){

						$media_type = $media_type->name($criteria['name']);
					}
				}

				$count = $media_type->count();

				if ($limit > 0 && $offset >= 0) {
					$media_type = $media_type->offset($offset)->limit($limit);
				}

			}

			$response = ['total' => $count, 'records' => $media_type->get()->toArray()];

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

}