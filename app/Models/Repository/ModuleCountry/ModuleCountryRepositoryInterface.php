<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 10/3/16
 * Time: 3:16 PM
 */

namespace FutureEd\Models\Repository\ModuleCountry;


interface ModuleCountryRepositoryInterface {

	public function getModuleCountries($criteria,$limit,$offset);

	public function addModuleCountries($module_id,$data);

	public function deleteModuleCountries($module_id);
}