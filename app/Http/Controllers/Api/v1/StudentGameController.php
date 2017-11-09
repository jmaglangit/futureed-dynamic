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

	/**
	 * Student Play game record.
	 * @param StudentGameRequest $request
	 * @return mixed
	 */
	public function studentPlayTime(StudentGameRequest $request){

		$data = $request->all();

		if($this->student->getStudentPlay($data['student_id'])){

			//add/update student game time
			$response =  $this->respondWithData($this->game_time->updateGamePlay($data['student_id'],[
				'game_id' => $data['game_id'],
				'countdown_time_played' => $data['countdown_time_played'] ,
				'date_played' => (empty($data['date_played'])) ? Carbon::now()->toDateString() : $data['date_played']]));

			if(!empty($data['countdown_time_played']) && $data['countdown_time_played'] <= config('futureed.false')){

				//update student
				$this->student->updateStudentDetails($data['student_id'],['can_play' => config('futureed.false')]);

				// return student can't play
				return $this->respondErrorMessage(2078);
			} else {
				return $response;
			}

		} else {
			// return student can't play
			return $this->respondErrorMessage(2078);
		}
	}

	/**
	 * @param $student_id
	 * @return mixed
	 */
	public function getStudentPlayTime($student_id){

		if($this->student->getStudentPlay($student_id)){
			$response = $this->game_time->getGamePlay($student_id);

			if(empty($response->toArray())){
				//create
				return $this->respondWithData($this->game_time->addGamePlay([
					'student_id' => $student_id,
					'countdown_time_played' => config('futureed.game_time')
				]));
			}elseif($response[0]->countdown_time_played <= config('futureed.false')){

				//update student
				$this->student->updateStudentDetails($response[0]->student_id,['can_play' => config('futureed.false')]);

				// return student can't play
				return $this->respondErrorMessage(2078);
			} else {
				return $this->respondWithData($response[0]);
			}
		} else {
			// return student can't play
			return $this->respondErrorMessage(2078);
		}
	}


}
