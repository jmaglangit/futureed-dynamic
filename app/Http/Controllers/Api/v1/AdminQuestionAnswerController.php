<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Models\Repository\QuestionAnswer\QuestionAnswerRepositoryInterface;
use FutureEd\Http\Requests\Api\AdminQuestionAnswerRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Filesystem\Filesystem;

use Illuminate\Http\Request;

class AdminQuestionAnswerController extends ApiController {

	protected $question_answer;
	protected $file;

	public function __construct(QuestionAnswerRepositoryInterface $question_answer, Filesystem $file){

		$this->question_answer = $question_answer;
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

				$record['records'][$k]['answer_image'] = config('futureed.answer_image_path_final_public').'/'.$v['id'].'/'.$v['answer_image'];
			}

		}

		return $this->respondWithData($record);
		

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AdminQuestionAnswerRequest $request)
	{

		$data = $request->only('module_id','question_id','code','answer_text','correct_answer','point_equivalent','image','label');


		//add data to question_answer table
		$return = $this->question_answer->addQuestionAnswer($data);

		//check if has images uploaded
		if($data['image']){

			$update = NULL;

			$from = config('futureed.answer_image_path');
			$to = config('futureed.answer_image_path_final').'/'.$return['id'];

			//check if directory don't exist, it will create new directory
			if (!$this->file->exists(config('futureed.answer_image_path_final'))){

				$this->file->makeDirectory(config('futureed.answer_image_path_final'),0775);
			}


			$image = explode('/',$data['image']);
			$image_type = explode('.',$image[1]);

			$update['original_image_name'] = $image[1];
			$update['answer_image'] = config('futureed.answer').'_'.$return['id'].'.'.$image_type[1];


			//move image to question directory
			$this->file->move($from.'/'.$image[0],$to);
			$this->file->copy($to.'/'.$image[1],$to.'/'.$update['answer_image']);


			//add questions_image and original_image_name
			$this->question_answer->updateQuestionAnswer($return['id'],$update);

		}



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
		$question_answer = $this->question_answer->viewQuestionAnswer($id);

		if(!$question_answer){

			return $this->respondErrorMessage(2120);
		}

		$question_answer->answer_image = config('futureed.answer_image_path_final_public').'/'.$question_answer->id.'/'.$question_answer->answer_image;


		return $this->respondWithData($question_answer);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, AdminQuestionAnswerRequest $request)
	{
		$data = $request->only('answer_text','correct_answer','point_equivalent','image','label');

		$question_answer = $this->question_answer->viewQuestionAnswer($id);

		if(!$question_answer){

			return $this->respondErrorMessage(2120);
		}

		if($data['image']){

			$from = config('futureed.answer_image_path');
			$to = config('futureed.answer_image_path_final').'/'.$id;

			$image = explode('/',$data['image']);
			$image_type = explode('.',$image[1]);

			$data['original_image_name'] = $image[1];
			$data['answer_image'] = config('futureed.answer').'_'.$id.'.'.$image_type[1];

			$this->file->deleteDirectory($to);
			$this->file->move($from.'/'.$image[0],$to);
			$this->file->copy($to.'/'.$image[1],$to.'/'.$data['answer_image']);

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
		$question_answer = $this->question_answer->viewQuestionAnswer($id);

		if(!$question_answer){

			return $this->respondErrorMessage(2120);
		}

		return $this->respondWithData($this->question_answer->deleteQuestionAnswer($id));

	}

}
