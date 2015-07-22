<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Models\Repository\QuestionAnswer\QuestionAnswerRepositoryInterface;
use FutureEd\Http\Requests\Api\QuestionAnswerRequest;
use Carbon\Carbon;
use FutureEd\Services\FileServices;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;

use Illuminate\Http\Request;

class QuestionAnswerController extends ApiController {

	protected $question_answer;

	protected $file_services;

	protected $file_system;

	public function __construct(
		QuestionAnswerRepositoryInterface $question_answer,
		FileServices $fileServices,
		Filesystem $filesystem
	){

		$this->question_answer = $question_answer;

		$this->file_services = $fileServices;

		$this->file_system = $filesystem;

	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function uploadQuestionAnswerImage()
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
			$input['file']->move(config('futureed.answer_image_path').'/'.$now,$image);

			//return the original name of the image
			$return['image_name'] = $now.'/'.$image;
		}

		return $this->respondWithData($return);


	}

	/**
	 * Delete Question Answer Image.
	 */
	public function deleteQuestionAnswerImage(){

		//get file to be deleted
		$delete_file = Input::get('delete_file');


		$delete_file = public_path() . $delete_file;

		$return = $this->file_services->deleteDirectory($delete_file);

		if($return) {
			return $this->respondWithData($return);
		}

		return $this->respondErrorMessage(2053);

	}



}
