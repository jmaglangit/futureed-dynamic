<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\QuestionTemplateOperation\QuestionTemplateOperationRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class QuestionTemplateOperationController extends ApiController {

	protected $question_template_operation;

	public function __construct(
		QuestionTemplateOperationRepositoryInterface $questionTemplateOperationRepositoryInterface
	){
		$this->question_template_operation = $questionTemplateOperationRepositoryInterface;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$criteria = [];

		if(Input::get('operation_data')){
			$criteria['operation_data'] = Input::get('operation_data');
		}

		if(Input::get('status')){
			$criteria['status'] = Input::get('status');
		}

		return $this->respondWithData($this->question_template_operation->getQuestionTemplateOperations());
	}

}
