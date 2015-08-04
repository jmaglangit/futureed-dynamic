<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Quote\QuoteRepositoryInterface as Quote;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;

class QuoteController extends ApiController {

	protected $quote;

	public function __construct(Quote $quote){

		$this->quote = $quote;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$avatar_id = null;
	
		//for avatar_id
		if(Input::get('avatar_id')){

			$avatar_id = Input::get('avatar_id');
		}
	
		
		return $this->respondWithData($this->quote->getQuotes($avatar_id));
		
	}


}
