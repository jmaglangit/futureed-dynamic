<?php
namespace FutureEd\Models\Repository\SubjectArea;

use FutureEd\Models\Core\SubjectArea;

class SubjectAreaRepository implements SubjectAreaRepositoryInterface {

	public function getAreasBySubjectId($subject_id) {
		
		$subject_areas = SubjectArea::subjectId($subject_id)->get();
		
		return $subject_areas;
		
	}

}