<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use FutureEd\Models\Repository\Question\QuestionRepositoryInterface;
use Illuminate\Support\Facades\Input;
use FutureEd\Http\Requests\Api\AdminQuestionRequest;
use Illuminate\Filesystem\Filesystem;

class AdminQuestionController extends ApiController {

	protected $question;
	protected $file;

	public function __construct(QuestionRepositoryInterface $question, Filesystem $file){

		$this->question = $question;
		$this->file = $file;
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

				$record['records'][$k]['questions_image'] = config('futureed.question_image_path_final').'/'.$v['id'].'/'.$v['questions_image'];
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

		$data =  $request->only('image','answer','seq_no','code','module_id','questions_text','status','question_type','points_earned','difficulty');

		$return = $this->question->addQuestion($data);

		//have image
		if($data['image']){

			$update = NULL;

			$from = config('futureed.question_image_path');
			$to = config('futureed.question_image_path_final').'/'.$return['id'];


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

		$question->questions_image = config('futureed.question_image_path_final').'/'.$question->id.'/'.$question->questions_image;

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
		$data =  $request->only('image','answer','questions_text','status','question_type','points_earned','difficulty','seq_no');

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
