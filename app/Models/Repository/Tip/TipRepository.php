<?php

namespace FutureEd\Models\Repository\Tip;

use FutureEd\Models\Core\Tip;
use League\Flysystem\Exception;


class TipRepository implements TipRepositoryInterface{

	//create record
	public function addTip($data){

		try {

			$tip = Tip::create($data);

		} catch(Exception $e) {

			return $e->getMessage();

		}

		return $tip;



	}

	public function getTips($criteria = array(), $limit = 0, $offset = 0){

		$tip = new Tip();

		$tip = $tip->with('subject','module','subjectarea')->where('tip_status','!=','Rejected');

		$count = 0;

		if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

			$count = $tip->count();

		} else {


			if (count($criteria) > 0) {

				//for tip_status
				if(isset($criteria['status'])) {

					$tip = $tip->tipStatus($criteria['status']);

				}

				//check for link_type
				if(isset($criteria['link_type'])){

					$tip = $tip->linkType($criteria['link_type']);
				}

				//check relation to subject
				if(isset($criteria['subject'])){

					$tip = $tip->subjectName($criteria['subject']);
				}

				//check relation to module
				if(isset($criteria['module'])){

					$tip = $tip->moduleName($criteria['module']);
				}

				//check relation to subject_area
				if(isset($criteria['area'])){

					$tip = $tip->subjectAreaName($criteria['area']);
				}

			}

			$count = $tip->count();

			if ($limit > 0 && $offset >= 0) {
				$tip = $tip->offset($offset)->limit($limit);
			}

		}

		return ['total' => $count, 'records' => $tip->get()->toArray()];

	}

}