<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use FutureEd\Models\Repository\Question\QuestionRepositoryInterface;
use Illuminate\Support\Facades\Input;
use FutureEd\Http\Requests\Api\AdminQuestionRequest;

class AdminQuestionController extends ApiController {

	protected $question;

	public function __construct(QuestionRepositoryInterface $question){

		$this->question = $question;
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

		//for module_id
		if(Input::get('module_id')){

			$criteria['module_id'] = Input::get('module_id');
		}

		//for question_type
		if(Input::get('question_type')){

			$criteria['question_type'] = Input::get('question_type');
		}

		//for questions_text
		if(Input::get('questions_text')){

			$criteria['questions_text'] = Input::get('questions_text');
		}

		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}

		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

		$record = $this->question->getQuestions($criteria , $limit, $offset );

		if($record['total'] > 0){

			foreach($record['records'] as $k=>$v){

				$record['records'][$k]['questions_image'] = config('futureed.question_image_path').'/'.$v['questions_image'];
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
	public function store(AdminQuestionRequest $request)
	{

		$data =  $request->only('image','answer','code','module_id','questions_text','status','question_type','points_earned','difficulty');

		//check if has images uploaded
		if($data['image']){
			//get image_name
			$image = $_FILES['image']['name'];

			//upload image file
			$data['image']->move(config('futureed.question_image_path'), $image);

			//set value for questions_images
			$data['questions_image'] = $image;

		}
		//get question count
		$data['seq_no'] = $this->question->getQuestionCount($data['module_id']) +1;

		$return = $this->question->addQuestion($data);

		return $this->respondWithData(['id'=>$return['id']]);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function show($id)
	{
		$question = $this->question->viewQuestion($id);

		if(!$question){

			return $this->respondErrorMessage(2120);
		}

		$question->questions_image = config('futureed.question_image_path').'/'.$question->questions_image;

		return $this->respondWithData($question);
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
	public function update($id,AdminQuestionRequest $request)
	{
		$data =  $request->only('answer','questions_text','status','question_type','points_earned','difficulty');

		$question = $this->question->viewQuestion($id);

		if(!$question){

			return $this->respondErrorMessage(2120);
		}

		//update data questions table
		$this->question->updateQuestion($id,$data);

		return $this->respondWithData($this->question->viewQuestion($id));



	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

		$question = $this->question->viewQuestion($id);

		if(!$question){

			return $this->respondErrorMessage(2120);
		}

		//delete question
		return $this->respondWithData($this->question->deleteQuestion($id));

	}

}
