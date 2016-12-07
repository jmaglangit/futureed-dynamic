<?php namespace FutureEd\Models\Repository\ModuleTranslation;


use FutureEd\Models\Core\Module;
use FutureEd\Models\Core\ModuleTranslation;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ModuleTranslationRepository implements ModuleTranslationRepositoryInterface{

	use LoggerTrait;

	protected $module;

	public function __construct(
		Module $module
	){
		$this->module = $module;
	}

	/**
	 * Initialize language translation with default language.
	 * @param $locale
	 * @return bool
	 */
	public function generateInitialLanguageTranslation($locale){
		DB::beginTransaction();
		try{
			//get all module translation
			$module_list = $this->module->all();

			//initiate module translate array
			$module_translate = [];

			//loop of each module
			foreach($module_list as $mod) {

				$module = $mod->toArray();

				$data = [
					'module_id' => $module['id'],
					'name' => $module['name'],
					'description' => $module['description'],
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

	/**
	 * Check locale language availability.
	 * @param $locale
	 * @return mixed
	 */
	public function checkLanguageAvailability($locale){


		return $this->module->first()->translate($locale);
	}

	/**
	 * Get collection of language available.
	 * @return mixed
	 */
	public function getLanguages(){

		return ModuleTranslation::select('locale')->groupBy('locale')->get();
	}

	/**
	 * Add new module translations.
	 * @param $data
	 * @param $target_lang
	 * @param $field
	 * @return bool
	 */
	public function updatedTranslation($data,$target_lang, $field){

		DB::beginTransaction();
		try {

			$translation = $this->module->find($data['id'])->translate($target_lang);

			$translation->{$field} = $data['string'];

			$translation->save();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return true;
	}

	/**
	 * Get Module Translations by locale.
	 * @param $locale
	 * @return array
	 */
	public function getModuleTranslations($locale){

		$current_locale = App::getLocale();

		App::setLocale(config('translatable.fallback_locale'));

		$module = new Module();
		$response = $module->with('translations')->get();

		$translations = [];
		foreach($response as $data){

			array_push($translations,[
				'module_id' => $data->id,
				'en' => $data->name,
				$locale => $data->translate($locale)->name
			]);
		}

		//return to current locale
		App::setLocale($current_locale);

		return $translations;
	}

	/**
	 * Get fields to be translated.
	 * @return mixed
	 */
	public function getTranslatedAttributes(){

		return with(new Module)->translatedAttributes;
	}

	/**
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return bool
	 */
	public function getCollection($criteria = [], $limit=0, $offset = 0){

		try{

			$module = new Module();

			$count = $module->count();

			if ($limit > 0 && $offset >= 0) {
				$module = $module->offset($offset)->limit($limit);
			}

			$response = ['total' => $count, 'records' => $module->get()->toArray()];

		}catch (\Exception $e){

			return false;
		}

		return $response;
	}

	/**
	 * Module count
	 * @return mixed
	 */
	public function count(){

		return Module::count();
	}


}