<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Models\Repository\QuestionAnswer\QuestionAnswerRepositoryInterface;
use FutureEd\Http\Requests\Api\QuestionAnswerRequest;

use Illuminate\Http\Request;

class QuestionAnswerController extends ApiController {

	protected $question_answer;

	public function __construct(QuestionAnswerRepositoryInterface $question_answer){

		$this->question_answer = $question_answer;

	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updateQuestionAnswerImage($id, QuestionAnswerRequest $request)
	{
		$data = $request->only('image');

		$question_answer = $this->question_answer->viewQuestionAnswer($id);

		if(!$question_answer){

			return $this->respondErrorMessage(2120);
		}


		//check if has images uploaded
		if($data['image']){
			//get image_name
			$image = $_FILES['image']['name'];

			//upload image file
			$data['image']->move(config('futureed.question_answer_image_path'), $image);

			//set value for answer_image
			$data['answer_image'] = $image;

		}

		//update questions_image
		$this->question_answer->updateQuestionAnswer($id,$data);

		return $this->respondWithData($this->question_answer->viewQuestionAnswer($id));


	}



}
