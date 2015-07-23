<?php namespace FutureEd\Models\Repository\StudentPoint;

interface StudentPointRepositoryInterface {

	public function getStudentPoints($criteria = array(), $limit = 0, $offset = 0);

}
