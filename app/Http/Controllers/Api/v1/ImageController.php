<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use League\Flysystem\Exception;
use League\Glide\ServerFactory;


class ImageController extends ApiController {

	//get path
	//convert to stream

	public function getImage(){

		//type -- answer, question
		$data = Input::only('id', 'filename', 'type');

		$uploads = config('futureed.uploads');

		$return = '/' . $data['type'] . '/' . $data['id'] . '/' . $data['filename'];

		//convert local path to url path

		$server = ServerFactory::create([
			'source' => $uploads
		]);

		if(file_exists($uploads . $return)){

			$server->outputImage($return, $_GET);

		}

		return $this->respondErrorMessage(2052);
	}

}
