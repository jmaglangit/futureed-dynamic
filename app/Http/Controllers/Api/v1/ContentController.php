<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Models\Repository\TeachingContent\TeachingContentRepositoryInterface;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class ContentController extends ApiController {

	protected $teaching_content;

	public function __construct( TeachingContentRepositoryInterface $teaching_content){

		$this->teaching_content = $teaching_content;

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function uploadContentImage()
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
			$input['file']->move(config('futureed.content_image_path').'/'.$now,$image);

			//return the original name of the image
			$return['image_name'] = $now.'/'.$image;
		}

		return $this->respondWithData($return);


	}

}
