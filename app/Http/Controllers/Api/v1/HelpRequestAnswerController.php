<?php namespace FutureEd\Http\Controllers\Api\v1;


use FutureEd\Http\Requests\Api\HelpRequestAnswerRequest;
use FutureEd\Models\Core\HelpRequestAnswer;
use FutureEd\Models\Repository\HelpRequestAnswer\HelpRequestAnswerRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class HelpRequestAnswerController extends ApiController {

	protected $help_request_answer;

	/**
	 *
	 */
	public function __construct(
		HelpRequestAnswerRepositoryInterface $helpRequestAnswerRepositoryInterface
	){

		$this->help_request_answer = $helpRequestAnswerRepositoryInterface;

	}

	/**
	 * Display a listing of Help Request Answer.
	 *
	 * @return Response
	 */
	public function index()
	{
		$criteria = [];
		$limit = 0;
		$offset = 0;

		/*
		 * Filters:
		 * help_request
		 * module
		 * subject_area
		 * subject
		 * request_answer_status
		 *
		 */
		if(Input::get('help_request')){

			$criteria['help_request'] = Input::get('help_request');
		}

		if(Input::get('module')){

			$criteria['module'] = Input::get('module');
		}

		if(Input::get('subject_area')){

			$criteria['subject_area'] = Input::get('subject_area');
		}

		if(Input::get('subject')){

			$criteria['subject'] = Input::get('subject');
		}

		if(Input::get('request_answer_status')){

			$criteria['request_answer_status'] = Input::get('request_answer_status');
		}

		if(Input::get('created_by')){

			$criteria['created_by'] = Input::get('created_by');
		}

		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}

		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

		return $this->respondWithData($this->help_request_answer->getHelpRequestAnswers($criteria,$limit,$offset));

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//TODO: Should store the creator of the record and time.
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

		$help_request_answer = $this->help_request_answer->getHelpRequestAnswer($id);

		return $this->respondWithData($help_request_answer);

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(HelpRequestAnswerRequest $request,$id)
	{
		$data = $request->only(
			'content',
			'status'
		);

		return $this->respondWithData(
			$this->help_request_answer->updateHelpRequestAnswer($id,$data)
		);

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

		return $this->respondWithData($this->help_request_answer->deleteHelpRequestAnswer($id));
	}

}
