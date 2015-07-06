<?php

namespace FutureEd\Models\Repository\Module;

use FutureEd\Models\Core\Module;
use League\Flysystem\Exception;


class ModuleRepository implements ModuleRepositoryInterface{

	public function addModule($data){

			try {

				$module = Module::create($data);

			} catch(Exception $e) {

				return $e->getMessage();

			}

			return $module;

	}

}