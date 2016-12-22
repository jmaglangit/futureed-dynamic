<?php namespace FutureEd\Models\Repository\GamePlayTime;


interface GamePlayTimeRepositoryInterface {

	public function addGamePlay($data);

	public function getGamePlay($student_id);

	public function updateGamePlay($student_id, $data);

	public function getStudentGamePlay($condition);

	public function recordGamePlay($condition,$values);
}