<?php

namespace FutureEd\Models\Repository\LearningStyle;

use FutureEd\Models\Core\LearningStyle;
use League\Flysystem\Exception;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;


class LearningStyleRepository implements LearningStyleRepositoryInterface{
	use LoggerTrait;

	/**
	 * Gets list of LearningStyle.
	 * @param $criteria
	 * @param $limit
	 * @param $offset
	 * @return array
	 */
	public function getLearningStyles($criteria = array(), $limit = 0, $offset = 0){
		DB::beginTransaction();

		try{
			$learning_style = new LearningStyle();

			$count = 0;

			if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

				$count = $learning_style->count();

			} else {


				if (count($criteria) > 0) {

					//check name
					if(isset($criteria['name'])){

						$learning_style = $learning_style->name($criteria['name']);
					}



				}

				$count = $learning_style->count();

				if ($limit > 0 && $offset >= 0) {
					$learning_style = $learning_style->offset($offset)->limit($limit);
				}

			}

			$response = ['total' => $count, 'records' => $learning_style->get()->toArray()];

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}
	
	/**
	 * Gets learning style by ls_banding.
	 * @param $ls_banding
	 * @return Object
	 */
	public function getLearningStyleByBanding($ls_banding) {
		DB::beginTransaction();

		try{
			$response = LearningStyle::lsBanding($ls_banding)->first();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}
}