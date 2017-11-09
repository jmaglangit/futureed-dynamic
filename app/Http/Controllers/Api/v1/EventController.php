<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use FutureEd\Models\Repository\Event\EventRepositoryInterface;
use Illuminate\Support\Facades\Input;

class EventController extends ApiController {

	protected $event;

	public function __construct(EventRepositoryInterface $event){

		$this->event = $event;

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

		return $this->respondWithData($this->event->getEvents($criteria , $limit, $offset ));

	}

}
