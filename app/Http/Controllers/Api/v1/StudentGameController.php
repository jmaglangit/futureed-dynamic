<?php namespace FutureEd\Http\Controllers\Api\v1;

use Carbon\Carbon;
use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\StudentGameRequest;
use FutureEd\Models\Repository\StudentGame\StudentGameRepositoryInterface;
use Illuminate\Support\Facades\Input;

class StudentGameController extends ApiController {

	protected $student_game;

	public function __construct(
		StudentGameRepositoryInterface $studentGameRepositoryInterface
	){
		$this->student_game = $studentGameRepositoryInterface;
	}

	/**
	 * Display a listing of the resource.
	 * @return array
	 */
	public function index()
	{
		$criteria = [];
		$limit = 0;
		$offset = 0;

		if(Input::get('user_id')){
			$criteria['user_id'] = Input::get('user_id');
		}

		if(Input::get('game_id')){
			$criteria['game_id'] = Input::get('game_id');
		}

		if (Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}

		if (Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

		return $this->respondWithData($this->student_game->getStudentGames($criteria,$limit,$offset));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->respondWithData($this->student_game->getStudentGame($id));
	}

	/**
	 * Get Students bought games
	 * @param $user_id
	 * @return mixed
	 */
	public function getStudentsGame($user_id){

		return $this->respondWithData($this->student_game->getStudentsGame($user_id));
	}

	/**
	 * Student Buys Game
	 * @param StudentGameRequest $request
	 * @return mixed
	 */
	public function studentBuyGame(StudentGameRequest $request){

		$data = $request->all();

		$data['earned_at'] = Carbon::now();

		return $this->respondWithData($this->student_game->studentBuyGame($data));
	}

}
