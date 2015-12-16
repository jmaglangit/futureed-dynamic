<?php namespace FutureEd\Services;

use Illuminate\Validation\Validator;

class ValidationServices extends Validator{

	/**
	 * Validate json format.
	 * @param $attribute
	 * @param $value
	 * @param $parameters
	 * @return bool
	 */
	public function validateJson($attribute,$value,$parameters){

		//check json format
		return (json_decode($value) != NULL);
	}

	//check graph answer format if correct
	public function validateGraphAnswer($attribute,$value,$parameters){

		$response = true;
		$graph = json_decode($value);

		if($graph <> NULL && isset($graph->answer)){

			foreach($graph->answer as $answer){
				$count = 0;
				foreach($answer as $data){
					$count++;
					//TODO: where it ended.
				}

			}
			$response =  true;
		}else {
			$response = false;
		}

		return $response;
	}

}