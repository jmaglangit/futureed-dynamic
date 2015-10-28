<?php namespace FutureEd\Models\Repository\StudentModule;

interface StudentModuleRepositoryInterface
{
	public function addStudentModule($data);

	public function getStudentModule($id);

	public function updateStudentModule($id, $data);

	public function viewStudentModule($id);

	public function countSubjectModuleDone($criteria = array());

	public function getStudentModuleStatus($id);

	public function updateStudentActivity($id,$data);

	public function getStudentModuleWrongCount($id);

	public function getStudentModuleByClass($student_id, $class_id);

	public function deleteStudentModule($id);

	public function getStudentModuleByClassId($class_id);

}