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
		//
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

//+-----------------------+---------------------------------------+------+-----+---------------------+----------------+
//| Field                 | Type                                  | Null | Key | Default             | Extra          |
//+-----------------------+---------------------------------------+------+-----+---------------------+----------------+
//| id                    | bigint(20) unsigned                   | NO   | PRI | NULL                | auto_increment |
//| student_id            | int(11)                               | NO   |     | NULL                |                |
//| content               | text                                  | NO   |     | NULL                |                |
//| help_request_id       | bigint(20)                            | NO   |     | NULL                |                |
//| module_id             | bigint(20)                            | NO   |     | NULL                |                |
//| subject_id            | bigint(20)                            | NO   |     | NULL                |                |
//| subject_area_id       | int(11)                               | NO   |     | NULL                |                |
//| rating                | tinyint(4)                            | YES  |     | NULL                |                |
//| seq_no                | bigint(20)                            | NO   |     | NULL                |                |
//| request_answer_status | enum('Pending','Accepted','Rejected') | NO   |     | NULL                |                |
//| status                | enum('Enabled','Disabled')            | NO   |     | NULL                |                |
//| points                | int(11)                               | YES  |     | NULL                |                |
//| created_by            | bigint(20)                            | NO   |     | NULL                |                |
//| updated_by            | bigint(20)                            | NO   |     | NULL                |                |
//| created_at            | timestamp                             | NO   |     | 0000-00-00 00:00:00 |                |
//| updated_at            | timestamp                             | NO   |     | 0000-00-00 00:00:00 |                |
//| deleted_at            | timestamp                             | YES  |     | NULL                |                |
//+-----------------------+---------------------------------------+------+-----+---------------------+----------------+

	public function update(HelpRequestAnswerRequest $request,$id)
	{
		$data = $request->only(
			'student_id',
			'content',
			'help_request_id',
			'module_id',
			'subject_id',
			'subject_area_id',
			'rating',
			'seq_no',
			'request_answer_status',
			'status',
			'points'
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

		return $this->respondWithData($this->help_request_answer->deleteHelperRequestAnswer($id));
	}

}
