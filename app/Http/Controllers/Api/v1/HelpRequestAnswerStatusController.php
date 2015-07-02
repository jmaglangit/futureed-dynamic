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

		return $this->help_request_answer->updateRequestAnswerStatus($id, $request->get('request_answer_status'));


	}


}
