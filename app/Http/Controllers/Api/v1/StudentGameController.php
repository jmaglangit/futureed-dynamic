<?php namespace FutureEd\Http\Controllers\Api\v1;

use Carbon\Carbon;
use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\StudentGameRequest;
use FutureEd\Models\Repository\Game\GameRepositoryInterface;
use FutureEd\Models\Repository\GamePlayTime\GamePlayTimeRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\StudentGame\StudentGameRepositoryInterface;
use Illuminate\Support\Facades\Input;
use FutureEd\Services\ErrorMessageServices as Error;

class StudentGameController extends ApiController {

	protected $student_game;
	protected $student;
	protected $game;
	protected $game_time;

	public function __construct(
		StudentGameRepositoryInterface $studentGameRepositoryInterface,
		StudentRepositoryInterface $studentRepositoryInterface,
		GameRepositoryInterface $gameRepositoryInterface,
		GamePlayTimeRepositoryInterface $gamePlayTimeRepositoryInterface
	){
		$this->student_game = $studentGameRepositoryInterface;
		$this->student = $studentRepositoryInterface;
		$this->game = $gameRepositoryInterface;
		$this->game_time = $gamePlayTimeRepositoryInterface;
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

		//get student points
		$student_id = $this->student->getStudentId($data['user_id']);
		$student_points = $this->student->getStudentPoints($student_id);
		$student_points_used = $this->student->getStudentPointsUsed($student_id);

		//get item points required.
		$item_points_required = $this->game->getGame($data['games_id']);
		$available_points = $student_points - $student_points_used;

		if($item_points_required->points_price > $available_points){
			return $this->respondErrorMessage(Error::NOT_ENOUGH_POINTS_ON_GAME);
		}

		$current_points_used = $student_points_used + $item_points_required->points_price;

		$this->student->updateStudentPointsUsed($student_id,$current_points_used);

		return $this->respondWithData($this->student_game->studentBuyGame($data));
	}

	//TODO: start play time, student and game needed.
	// check if exists, update time
	public function studentPlayTime(StudentGameRequest $request){

		$data = $request->all();

		//student id

		//check if student can play then
		//check if exist -- then update
		// if not exist -- then create

		if($this->student->getStudentPlay($data['id'])){
			//add/update student game time

		} else {
			// return student can't play
		}




	}


}
