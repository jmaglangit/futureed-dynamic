<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Models\Repository\Game\GameRepositoryInterface;
use Illuminate\Support\Facades\Input;

class GameController extends ApiController {

	protected $game;

	public function __construct(
		GameRepositoryInterface $gameRepositoryInterface
	){
		$this->game = $gameRepositoryInterface;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$criteria = [];
		$limit = 0;
		$offset = 0;

		if(Input::get('code')){
			$criteria['code'] = Input::get('code');
		}

		if(Input::get('name')){
			$criteria['name'] = Input::get('name');
		}

		if(Input::get('points_price')){
			$criteria['points_price'] = Input::get('points_price');
		}

		if (Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}

		if (Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

		return $this->respondWithData($this->game->getGames($criteria,$limit,$offset));
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->respondWithData($this->game->getGame($id));
	}

	/**
	 * Getting games with user id
	 * @param $user_id
	 * @return mixed
	 */
	public function getGamesWithUser($user_id){

		$limit = 0;
		$offset = 0;

		if (Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}

		if (Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

		return $this->respondWithData($this->game->getGamesWithUser($user_id,$limit,$offset));
	}


}
