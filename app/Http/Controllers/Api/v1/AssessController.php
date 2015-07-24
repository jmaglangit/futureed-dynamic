<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Services\IAssessServices as iAssess;

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

}