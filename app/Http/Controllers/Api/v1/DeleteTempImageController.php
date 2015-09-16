<?php namespace FutureEd\Http\Controllers\api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;

class DeleteTempImageController extends ApiController {

	protected $file_system;

	public function __construct(Filesystem $file_system){

		$this->file_system = $file_system;

	}

	/**
	 * Deleting temp files.
	 *
	 * @return Response
	 */
	public function deleteTempImages(){


		$this->file_system->deleteDirectory(config('futureed.content_image_path'));

		$this->file_system->deleteDirectory(config('futureed.answer_image_path'));

		$this->file_system->deleteDirectory(config('futureed.question_image_path'));

		return $this->respondWithData('true');

	}



}
