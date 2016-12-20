<?php namespace FutureEd\Models\Repository\GamePlayTime;


interface GamePlayTimeRepositoryInterface {

	//add
	public function addGamePlay($data);

	//get by spec
	public function getGamePlay($student_id);

	//update game play
	public function updateGamePlay($student_id, $data);

	//record game play
	public function recordGamePlay($condition,$values);
}