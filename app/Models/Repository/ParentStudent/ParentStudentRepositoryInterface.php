<?php namespace FutureEd\Models\Repository\ParentStudent;


interface ParentStudentRepositoryInterface {

	public function addParentStudent($data);

	public function checkParentStudent($parent_id,$student_id);

}