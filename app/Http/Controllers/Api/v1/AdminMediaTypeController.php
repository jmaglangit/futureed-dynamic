<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Models\Repository\MediaType\MediaTypeRepositoryInterface;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;

class AdminMediaTypeController extends ApiController {

	protected $media_type;

	public function __construct(MediaTypeRepositoryInterface $media_type ){

		$this->media_type = $media_type;

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$criteria = [];
		$limit = 0 ;
		$offset = 0;


		//for name
		if(Input::get('name')){

			$criteria['name'] = Input::get('name');
		}

		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}

		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

		$record = $this->media_type->getMediaTypes($criteria , $limit, $offset );


		return $this->respondWithData($record);
	}

}
