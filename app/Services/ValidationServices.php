<?php namespace FutureEd\Services;

use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Validator as facade_validator;

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

	//validate if url exists
	/**
	 * Validate if URL exists.
	 * @param $attribute
	 * @param $value
	 * @param $parameters
	 * @return bool
	 */
	public function validateUrlExists($attribute,$value,$parameters){

		$file = url() . $value;
		$file = str_replace(' ','%20',$file);
		$file_headers = @get_headers($file);
		if($file_headers[0] == 'HTTP/1.1 200 OK') {
			return true;
		}
		else {
			return false;
		}
	}

	//check graph answer format if correct
	/**
	 * Check Graph answer format/values if correct
	 * @param $attribute
	 * @param $value
	 * @param $parameters
	 * @return bool
	 */
	public function validateGraphAnswer($attribute,$value,$parameters){


		$graph = json_decode($value);


		if($graph <> NULL && isset($graph->answer)){

			foreach($graph->answer as $answer){



				switch($parameters[0]){
					case 'GR' :
						//should only have 4 valued answer.
						if(count((array) $answer) <> 4){
							return false;
						}
						//validate field, image, count, count_objects
						$rules = [
							'field' => 'required|string',
							'image' => 'required|url_exists',
							'count' => 'required|integer',
							'count_objects' => 'required|integer'
						];

						$data = [
							'field' => $answer->field,
							'image' => $answer->image,
							'count' => $answer->count,
							'count_objects' => $answer->count_objects
						];

						$validator = facade_validator::make($data,$rules);

						if($validator->fails()){
							return false;
						}
						break;
					case 'QUAD':
						//should only have 2 valued answer.
						if(count((array) $answer) <> 2){
							return false;
						}
						//validate x and y
						$rules = [
							'x' => 'required|integer',
							'y' => 'required|integer'
						];

						//check if x and y is set.
						if(!isset($answer->x) || !isset($answer->y)){

							return false;
						}

						$data = [
							'x' => $answer->x,
							'y' => $answer->y
						];

						$validator = facade_validator::make($data,$rules);

						if($validator->fails()){
							return false;
						}

						break;
					default:
						return false;
						break;
				}

			}
			return true;
		}else {
			return false;
		}
	}

}