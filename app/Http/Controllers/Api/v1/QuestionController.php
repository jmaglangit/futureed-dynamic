<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use FutureEd\Http\Requests\Api\QuestionRequest;
use Illuminate\Support\Facades\Input;
use FutureEd\Models\Repository\Question\QuestionRepositoryInterface;

class QuestionController extends ApiController {

	protected $question;

	public function __construct(QuestionRepositoryInterface $question){

		$this->question = $question;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updateQuestionImage($id, QuestionRequest $request)
	{
		$data = $request->only('image');

		$question = $this->question->viewQuestion($id);

		if(!$question){

			return $this->respondErrorMessage(2120);
		}

		//check if has images uploaded
		if($data['image']){
			//get image_name
			$image = $_FILES['image']['name'];

			//upload image file
			$data['image']->move(config('futureed.question_image_path'), $image);

			//set value for questions_images
			$data['questions_image'] = $image;

		}

		//update questions_image
		$this->question->updateQuestion($id,$data);

		return $this->respondWithData($this->question->viewQuestion($id));

	}


}
