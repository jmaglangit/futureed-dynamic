<?php
namespace FutureEd\Models\Repository\StudentBadge;

interface StudentBadgeRepositoryInterface {

	public function getStudentBadges($criteria = array(), $limit = 0, $offset = 0);

	public function updateStudentBadge($id,$data);

	public function viewStudentBadge($id);

	public function deleteStudentBadge($id);

	public function addStudentBadge($data);


}