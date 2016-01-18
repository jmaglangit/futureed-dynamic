<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 7/6/15
 * Time: 2:13 PM
 */

namespace FutureEd\Models\Repository\AgeGroup;


use FutureEd\Models\Core\AgeGroup;

class AgeGroupRepository implements AgeGroupRepositoryInterface{

	/**
	 * Get all list of Age Groups
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function getAges(){

		DB::beginTransaction();

		try{
			$response = AgeGroup::all();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

}