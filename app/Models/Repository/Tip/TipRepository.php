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

}