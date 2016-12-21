<?php namespace FutureEd\Models\Repository\GamePlayTime;


use FutureEd\Models\Core\GamePlayTime;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class GamePlayTimeRepository implements GamePlayTimeRepositoryInterface{

	use LoggerTrait;

	/**
	 * @param $data
	 * @return bool|static
	 */
	public function addGamePlay($data){

		DB::beginTransaction();

		try{

			 $response = GamePlayTime::create($data);

		} catch(\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $student_id
	 * @return mixed
	 */
	public function getGamePlay($student_id){

		return GamePlayTime::where('student_id',$student_id)->get();
	}

	/**
	 * @param $student_id
	 * @param $data
	 * @return bool
	 */
	public function updateGamePlay($student_id, $data){

		DB::beginTransaction();

		try{

			 $response = GamePlayTime::where('student_id',$student_id)->update($data);

		} catch(\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

	}

	/**
	 * Get student game play
	 * @param $condition
	 * @return mixed
	 */
	public function getStudentGamePlay($condition){

		return GamePlayTime::where('student_id',$condition['student_id'])
			->where('game_id',$condition['game_id'])->get();
	}

	/**
	 * Record Game Play Time
	 * @param $condition
	 * @param $values
	 * @return bool|static
	 */
	public function recordGamePlay($condition,$values){

		DB::beginTransaction();

		try{

			$response = GamePlayTime::updateOrCreate($condition,$values);

		} catch(\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

	}
}