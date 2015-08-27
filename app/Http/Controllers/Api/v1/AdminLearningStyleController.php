<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Models\Repository\LearningStyle\LearningStyleRepositoryInterface;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;

class AdminLearningStyleController extends ApiController {

	protected $learning_style;

	public function __construct(LearningStyleRepositoryInterface $learning_style){

		$this->learning_style = $learning_style;

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

		//get list of learning_style
		return $this->respondWithData($this->learning_style->getLearningStyles($criteria , $limit, $offset ));
	}

}
