<?php
namespace FutureEd\Models\Repository\StudentModuleAnswer;

interface StudentModuleAnswerRepositoryInterface
{
	public function addStudentModuleAnswer($data);

	public function getStudentModuleAnswer($student_module_id, $module_id);
}