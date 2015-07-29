<?php namespace FutureEd\Models\Repository\StudentPoint;

interface StudentPointRepositoryInterface {

	public function getStudentPoints($criteria = array(), $limit = 0, $offset = 0);

	public function viewStudentPoint($id);

	public function updateStudentPoint($id,$data);

}
