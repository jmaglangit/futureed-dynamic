<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use FutureEd\Http\Requests\Api\QuestionRequest;
use Illuminate\Support\Facades\Input;
use FutureEd\Models\Repository\Question\QuestionRepositoryInterface;
use Carbon\Carbon;

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
	public function uploadQuestionImage(QuestionRequest $request)
	{
		$data = $request->only('image');
		$now = Carbon::now()->timestamp;

		$return = NULL;

		//check if has images uploaded
		if($data['image']){
			//get image_name
			$image = $_FILES['image']['name'];

			//uploads image file
			$data['image']->move(config('futureed.question_image_path').'/'.$now,$image);

			//return the original name of the image
			$return['image_name'] = $now.'/'.$image;
		}

		return $this->respondWithData($return);

	}


}
