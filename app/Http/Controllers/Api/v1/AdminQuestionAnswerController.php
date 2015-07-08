<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Models\Repository\QuestionAnswer\QuestionAnswerRepositoryInterface;
use FutureEd\Http\Requests\Api\AdminQuestionAnswerRequest;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;

class AdminQuestionAnswerController extends ApiController {

	protected $question_answer;

	public function __construct(QuestionAnswerRepositoryInterface $question_answer){

		$this->question_answer = $question_answer;

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$criteria = [];
		$limit = 0 ;
		$offset = 0;

		//for tip_status
		if(Input::get('question_id')){

			$criteria['question_id'] = Input::get('question_id');
		}

		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}

		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

		$record = $this->question_answer->getQuestionAnswers($criteria , $limit, $offset );

		if($record['total'] > 0){

			foreach($record['records'] as $k=>$v){

				$record['records'][$k]['questions_image'] = config('futureed.question_answer_image_path').'/'.$v['answer_image'];
			}

		}

		return $this->respondWithData($record);
		

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AdminQuestionAnswerRequest $request)
	{

		$data = $request->only('module_id','question_id','code','answer_text','correct_answer','point_equivalent','image');

		//check if has images uploaded
		if($data['image']){
			//get image_name
			$image = $_FILES['image']['name'];

			//upload image file
			$data['image']->move(config('futureed.question_answer_image_path'), $image);

			//set value for answer_image
			$data['answer_image'] = $image;

		}

		//add data to question_answer table
		$return = $this->question_answer->addQuestionAnswer($data);

		return $this->respondWithData(['id'=>$return['id']]);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, AdminQuestionAnswerRequest $request)
	{
		$data = $request->only('answer_text','correct_answer','point_equivalent');

		$question_answer = $this->question_answer->viewQuestionAnswer($id);

		if(!$question_answer){

			return $this->respondErrorMessage(2120);
		}

		//update question_answer
		$this->question_answer->updateQuestionAnswer($id,$data);

		return $this->respondWithData($this->question_answer->viewQuestionAnswer($id));

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
