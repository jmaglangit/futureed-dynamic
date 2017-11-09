<?php namespace FutureEd\Models\Repository\ModuleGroup;

interface ModuleGroupRepositoryInterface {

	public function addModuleGroup($data);

	public function getModuleGroups($criteria = array(), $limit = 0, $offset = 0);

	public function getModuleGroup($id);

	public function updateModuleGroup($id,$data);

	public function deleteModuleGroup($id);

}