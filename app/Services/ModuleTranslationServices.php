<?php namespace FutureEd\Services;


use FutureEd\Models\Core\Module;
use FutureEd\Models\Repository\ModuleTranslation\ModuleTranslationRepositoryInterface;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class ModuleTranslationServices {

	use LoggerTrait;

	protected $module_translation;

	protected $module;

	public function __construct(
		ModuleTranslationRepositoryInterface $moduleTranslationRepositoryInterface,
		Module $module
	){
		$this->module_translation = $moduleTranslationRepositoryInterface;
		$this->module = $module;
	}

	//auto generate default translation on table
	//reset of all translation to config defualt translations.
	public function generateDefaultTranslation($locale){

		DB::beginTransaction();
		try{
			//get all module translation
			$module_list = $this->module->all();

			//initiate module translate array
			$module_translate = [];

			//loop of each module
			foreach($module_list as $module) {

				$data = [
					'module_id' => $module['id'],
					'name' => $module['name'],
					'locale' => $locale
				];

				//add record to array
				array_push($module_translate,$data);
			}

			//delete all existing translations.
			\DB::table('module_translations')->where('locale','=',$locale)->delete();

			//insert to module_translation
			\DB::table('module_translations')->insert($module_translate);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();
		return true;

	}


}