<?php namespace FutureEd\Models\Repository\StudentGame;


use FutureEd\Models\Core\StudentGame;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class StudentGameRepository implements StudentGameRepositoryInterface{

	use LoggerTrait;

	/**
	 * Get bought games
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array|bool
	 */
	public function getStudentGames($criteria = [], $limit = 0, $offset = 0){

		try{

			$student_games = new StudentGame();

			if(isset($criteria['user_id'])){

				$student_games = $student_games->userId($criteria['user_id']);
			}

			if(isset($criteria['game_id'])){

				$student_games = $student_games->gameId($criteria['game_id']);
			}

			$count = $student_games->count();

			if($limit > 0 && $offset >= 0) {

				$student_games = $student_games->limit($limit)->offset($offset);
			}

			$response = [
				'total' => $count,
				'records' => $student_games->get()->toArray()
			];

		} catch (\Exception $e) {

			$this->errorLog($e->getMessage());

			return false;
		}

		return $response;
	}

	/**
	 * Get bought game
	 * @param $id
	 * @return \Illuminate\Support\Collection|null|static
	 */
	public function getStudentGame($id){

		return StudentGame::find($id);
	}

	/**
	 * Get bought game(s) by student
	 * @param $user_id
	 * @return mixed
	 */
	public function getStudentsGame($user_id){

		return StudentGame::userId($user_id)->get();
	}

	/**
	 * Student Buys Game
	 * @param $data
	 * @return bool|static
	 */
	public function studentBuyGame($data){

		DB::beginTransaction();

		try{

			$response = StudentGame::create($data);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

}