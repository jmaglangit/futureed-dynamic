<?php

namespace FutureEd\Models\Repository\LearningStyle;

use FutureEd\Models\Core\LearningStyle;
use League\Flysystem\Exception;


class LearningStyleRepository implements LearningStyleRepositoryInterface{

	/**
	 * Gets list of LearningStyle.
	 * @param $criteria
	 * @param $limit
	 * @param $offset
	 * @return array
	 */
	public function getLearningStyles($criteria = array(), $limit = 0, $offset = 0){

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

		return ['total' => $count, 'records' => $learning_style->get()->toArray()];

	}
	
	/**
	 * Gets learning style by ls_banding.
	 * @param $ls_banding
	 * @return Object
	 */
	public function getLearningStyleByBanding($ls_banding) {
		
		$learning_style = LearningStyle::lsBanding($ls_banding)->first();
		
		return $learning_style;
	
	}
}