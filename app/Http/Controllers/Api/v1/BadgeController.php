<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use FutureEd\Models\Repository\Badge\BadgeRepositoryInterface;
use Illuminate\Support\Facades\Input;

class BadgeController extends ApiController {

	protected $badge;

	public function __construct(BadgeRepositoryInterface $badge){

		$this->badge = $badge;
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

		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

		return $this->respondWithData($this->badge->getBadges($criteria , $limit, $offset ));

	}

}
