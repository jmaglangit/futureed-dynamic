<?php
namespace FutureEd\Models\Repository\Module;

interface ModuleRepositoryInterface {

	public function addModule($data);

	public function getModules($criteria = array(), $limit = 0, $offset = 0);

}