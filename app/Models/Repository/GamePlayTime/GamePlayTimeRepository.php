<?php namespace FutureEd\Models\Repository\GamePlayTime;


use FutureEd\Models\Core\GamePlayTime;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class GamePlayTimeRepository implements GamePlayTimeRepositoryInterface{

	use LoggerTrait;

	// add
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

	//get game play
	public function getGamePlay($student_id){

		return GamePlayTime::where('student_id',$student_id)->get();
	}

	//update game
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