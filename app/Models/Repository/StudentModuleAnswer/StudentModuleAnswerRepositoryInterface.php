<?php
namespace FutureEd\Models\Repository\StudentModuleAnswer;

interface StudentModuleAnswerRepositoryInterface
{
	public function addStudentModuleAnswer($data);

	public function getStudentModuleAnswer($student_module_id, $module_id);

	public function deletedStudentModuleAnswer($student_module_id, $question_id);
}