<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Services\IAssessServices as iAssess;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use FutureEd\Http\Requests\Api\LearningStyleRequest;

class AssessController extends ApiController {

	/**
     *   holds the iAssess Service
     */
	protected $iassess;

	/**
	 * Assess Controller constructor
	 *
	 * @param IAssessServices
	 * @return void
	 */
	public function __construct(iAssess $iassess) 
	{
		$this->iassess = $iassess;
	}

	/**
	 * get Test data
	 *
	 * @param void
	 * @return Resource
	 */
	 public function getTest(){

		if($this->iassess->getTestData()) {
		
			$data = $this->iassess->data;
			
			return $this->respondWithData($data);
			
		} else {
		
			return $this->respondWithError();
			
		}

    }

	/**
	 * save Test data
	 *
	 * @param void
	 * @return Resource
	 */
	 public function saveTest(LearningStyleRequest $request){

		$input = Input::all();
				
		if($this->iassess->saveTestData($input)) {
		
			$data = $this->iassess->data;
			
			return $this->respondWithData($data);
			
		} else {
		
			return $this->respondWithError();
			
		}

    }


}