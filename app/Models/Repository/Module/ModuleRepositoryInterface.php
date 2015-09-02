<?php
namespace FutureEd\Models\Repository\Module;

interface ModuleRepositoryInterface
{

	public function addModule($data);

	public function getModules($criteria = array(), $limit = 0, $offset = 0);

	public function viewModule($id);

	public function updateModule($id, $data);

	public function deleteModule($id);

	public function getPointsToFinish($module_id);

	public function countSubjectModule($subject_id, $grade_id);

	public function getModulesByStudentProgress($criteria,  $offset = 0, $limit = 0);

}