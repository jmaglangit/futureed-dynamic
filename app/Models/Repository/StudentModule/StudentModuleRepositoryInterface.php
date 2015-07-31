<?php namespace FutureEd\Models\Repository\StudentModule;

interface StudentModuleRepositoryInterface {
	public function addStudentModule($data);

	public function getStudentModule($id);

	public function updateStudentModule($id, $data);

	public function viewStudentModule($id);
}