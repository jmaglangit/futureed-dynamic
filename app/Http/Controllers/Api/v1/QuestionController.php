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
	public function uploadQuestionImage()
	{

		$input = Input::only('file');

		$now = Carbon::now()->timestamp;
		$return = NULL;
		define('MB',1048576);

		//check if has images uploaded
		if($input['file'])
		{
			if($_FILES['file']['type'] != 'image/jpeg' && $_FILES['file']['type'] != 'image/png'){

				return $this->respondErrorMessage(2142);

			}


			if($_FILES['file']['size'] > 2 * MB){

				return $this->respondErrorMessage(2143);

			}

			//get image_name
			$image = $_FILES['file']['name'];

			//uploads image file
			$input['file']->move(config('futureed.question_image_path').'/'.$now,$image);

			//return the original name of the image
			$return['image_name'] = $now.'/'.$image;
		}

		return $this->respondWithData($return);

	}


}
