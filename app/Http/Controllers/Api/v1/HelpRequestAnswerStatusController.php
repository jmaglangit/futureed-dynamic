<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;

use FutureEd\Models\Repository\HelpRequestAnswer\HelpRequestAnswerRepositoryInterface;
use FutureEd\Http\Requests\Api\HelpRequestAnswerStatusRequest;
use Illuminate\Support\Facades\Input;

class HelpRequestAnswerStatusController extends ApiController {

	protected $help_request_answer;

	/**
	 * Initialized
	 * @param HelpRequestAnswerRepositoryInterface $helpRequestAnswerRepositoryInterface
	 */
	public function __construct(
		HelpRequestAnswerRepositoryInterface $helpRequestAnswerRepositoryInterface
	){
		$this->help_request_answer = $helpRequestAnswerRepositoryInterface;

	}

	/**
	 * Update status
	 * @param HelpRequestAnswerStatusRequest $request
	 * @param $id
	 * @return mixed
	 */
	public function updateStatus(HelpRequestAnswerStatusRequest $request, $id){

		$data  = $request->only('request_answer_status','rated_by','rating');
		$this->help_request_answer->updateHelpRequestAnswer($id, $data);

		return $this->respondWithData($this->help_request_answer->getHelpRequestAnswer($id));


	}


}
