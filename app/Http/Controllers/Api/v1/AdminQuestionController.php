<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Services\QuestionServices;
use Illuminate\Http\Request;
use FutureEd\Models\Repository\Question\QuestionRepositoryInterface;
use Illuminate\Support\Facades\Input;
use FutureEd\Http\Requests\Api\AdminQuestionRequest;
use Illuminate\Filesystem\Filesystem;

class AdminQuestionController extends ApiController {

	protected $question;
	protected $file;
	protected $question_service;

	public function __construct(
		QuestionRepositoryInterface $question,
		Filesystem $file,
		QuestionServices $questionServices
		){

		$this->question = $question;
		$this->file = $file;
		$this->question_service = $questionServices;

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

		return $this->respondWithData($this->question->getQuestions($criteria , $limit, $offset ));
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

		$data =  $request->only('image','answer','seq_no','code','module_id','questions_text','status','question_type','points_earned','difficulty');


		$last_sequence = $this->question->getLastSequence($data['module_id'],$data['difficulty']);

		//get sequence
		if(!$data['seq_no'] || $data['seq_no'] > $last_sequence ) {

			//get last sequence and add.
			$data['seq_no'] = $last_sequence + 1;

		}else {

			//move sequence
			$current_sequence = $this->question_service->updateSequence($data['module_id'],$data['seq_no'],$data['difficulty']);

			//update sequence
			$this->question->updateSequence($current_sequence);
		}

		$return = $this->question->addQuestion($data);

		//have image
		if($data['image']){

			$update = NULL;

			$from = config('futureed.question_image_path');
			$to = config('futureed.question_image_path_final').'/'.$return['id'];

			//check if directory don't exist, it will create new directory
			if (!$this->file->exists(config('futureed.question_image_path_final'))){

				$this->file->makeDirectory(config('futureed.question_image_path_final'));
			}

			$image = explode('/',$data['image']);
			$image_type = explode('.',$image[1]);

			$update['original_image_name'] = $image[1];
			$update['questions_image'] = config('futureed.question').'_'.$return['id'].'.'.$image_type[1];

			//move image to question directory
			$this->file->move($from.'/'.$image[0],$to);
			$this->file->copy($to.'/'.$image[1],$to.'/'.$update['questions_image']);


			//add questions_image and original_image_name
			$this->question->updateQuestion($return['id'],$update);

		}

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
		$data =  $request->only('image','answer','question_order_text','questions_text','status','question_type'
			,'points_earned','difficulty','seq_no');

		$question = $this->question->viewQuestion($id);

		if(!$question){

			return $this->respondErrorMessage(2120);
		}

		if($data['image']){

			$from = config('futureed.question_image_path');
			$to = config('futureed.question_image_path_final').'/'.$id;

			$image = explode('/',$data['image']);
			$image_type = explode('.',$image[1]);

			$data['original_image_name'] = $image[1];
			$data['questions_image'] = config('futureed.question').'_'.$id.'.'.$image_type[1];

			$this->file->deleteDirectory($to);
			$this->file->move($from.'/'.$image[0],$to);
			$this->file->copy($to.'/'.$image[1],$to.'/'.$data['questions_image']);

		}

		//update sequence
		//get current sequence and compare
		$current_sequence = $this->question->getQuestionSequenceNo($id);

		$last_current_seq_no = $this->question->getLastSequence($current_sequence[0]->module_id,$data['difficulty']);
		$data['seq_no'] = ($data['seq_no'] > $last_current_seq_no)? $last_current_seq_no : $data['seq_no'];

		if($data['seq_no'] <> $current_sequence[0]->seq_no){

			//pull sequence number.
			$pulled = $this->question_service->pullSequenceNo($current_sequence[0]->module_id, $current_sequence[0]->seq_no,$id,$data['difficulty']);
			
			//update sequence
			$this->question->updateSequence($pulled);

			//insert sequence number.
			$current_sequence = $this->question_service->updateSequence($current_sequence[0]->module_id,$data['seq_no'],$data['difficulty']);


			//update sequence
			$this->question->updateSequence($current_sequence);

		}

		//if not equal remove number and fill in.
		//update sequence with new sequence

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

		$current_sequence = $this->question->getQuestionSequenceNo($id);

		//pull sequence number.
		$pulled = $this->question_service->pullSequenceNo($current_sequence[0]->module_id, $current_sequence[0]->seq_no,$id,$question['difficulty']);

		//update sequence
		$this->question->updateSequence($pulled);

		//delete question
		return $this->respondWithData($this->question->deleteQuestion($id));

	}

}
