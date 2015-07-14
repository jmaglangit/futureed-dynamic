<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Models\Repository\QuestionAnswer\QuestionAnswerRepositoryInterface;
use FutureEd\Http\Requests\Api\QuestionAnswerRequest;
use Carbon\Carbon;

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
	public function uploadQuestionAnswerImage(QuestionAnswerRequest $request)
	{
		$data = $request->only('image');
		$now = Carbon::now()->timestamp;

		$return = NULL;

		//check if has images uploaded
		if($data['image']){
			//get image_name
			$image = $_FILES['image']['name'];

			//upload image file
			$data['image']->move(config('futureed.answer_image_path').'/'.$now,$image);

			//return the original name of the image
			$return['image_name'] = $now.'/'.$image;
		}

		return $this->respondWithData($return);


	}



}
