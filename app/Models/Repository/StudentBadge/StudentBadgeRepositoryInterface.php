<?php
namespace FutureEd\Models\Repository\StudentBadge;

interface StudentBadgeRepositoryInterface {

	public function getStudentBadges($criteria = array(), $limit = 0, $offset = 0);

}