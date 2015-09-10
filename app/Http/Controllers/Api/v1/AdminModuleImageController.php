<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use FutureEd\Http\Requests\Api\AdminModuleImageRequest;

use Illuminate\Http\Request;

class AdminModuleImageController extends ApiController {

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AdminModuleImageRequest $request)
	{

		$input = $request->get('file');

		$now = Carbon::now()->timestamp;
		$return = NULL;
		define('MB',1048576);

		//check if has images uploaded
		if($input['file'])
		{
			if($_FILES['file']['type'] != 'image/jpeg' && $_FILES['file']['type'] != 'image/png'){

				return $this->respondErrorMessage(2142);

			}

			$image_type = explode('.',$_FILES['file']['name']);

			if(count($image_type) >= 3){

				return $this->respondErrorMessage(2146);

			}


			if($_FILES['file']['size'] > 2 * MB){

				return $this->respondErrorMessage(2143);

			}

			//get image_name
			$image = $_FILES['file']['name'];

			//uploads image file
			$input['file']->move(config('futureed.icon_image_path').'/'.$now,$image);

			//return the original name of the image
			$return['image_name'] = $now.'/'.$image;
		}

		return $this->respondWithData($return);
	}

}
