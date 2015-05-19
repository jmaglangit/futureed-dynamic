<?php
namespace FutureEd\Models\Repository\SubjectArea;

interface SubjectAreaRepositoryInterface {

	public function getAreasBySubjectId($subject_id);

}