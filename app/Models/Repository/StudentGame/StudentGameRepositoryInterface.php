<?php namespace FutureEd\Models\Repository\StudentGame;

interface StudentGameRepositoryInterface {

	public function getStudentGames($criteria = [], $limit = 0, $offset = 0);

	public function getStudentGame($id);

	public function getStudentsGame($user_id);

	public function studentBuyGame($data);
}