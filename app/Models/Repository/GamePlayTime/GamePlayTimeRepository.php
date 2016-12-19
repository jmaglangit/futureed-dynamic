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
	public function getGamePlay($student_id, $game_id){

		return GamePlayTime::where('student_id',$student_id)
			->where('game_id',$game_id)->get();
	}
}