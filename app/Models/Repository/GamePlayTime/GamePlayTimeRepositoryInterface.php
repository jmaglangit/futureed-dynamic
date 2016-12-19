<?php namespace FutureEd\Models\Repository\GamePlayTime;


interface GamePlayTimeRepositoryInterface {

	//add
	public function addGamePlay($data);

	//get by spec
	public function getGamePlay($student_id, $game_id);
}