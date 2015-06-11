<?php namespace FutureEd\Models\Repository\ParentStudent;


use FutureEd\Models\Core\ParentStudent;

class ParentStudentRepository implements ParentStudentRepositoryInterface{

	//add record to db
	public function addParentStudent($data){

		$parent_student  = new ParentStudent();

		$data['created_by'] = 1;
		$data['updated_by'] = 1;

		try {

			$parent_student = $parent_student->create($data);

		} catch(Exception $e) {

			return $e->getMessage();

		}

		return $parent_student;
	}

	//check if parent added already a specific student
	public function checkParentStudent($parent_id,$student_id){

		$parent_student = new ParentStudent();

		$parent_student = $parent_student->where('parent_user_id',$parent_id);
		$parent_student = $parent_student->where('student_user_id',$student_id)->pluck('id');

		return $parent_student;

	}

}