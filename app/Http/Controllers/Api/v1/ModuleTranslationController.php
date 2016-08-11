<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Models\Repository\ModuleTranslation\ModuleTranslationRepositoryInterface;
use FutureEd\Services\ExcelServices;
use FutureEd\Services\ModuleTranslationServices;
use FutureEd\Http\Requests\Api\ModuleTranslationRequest;

class ModuleTranslationController extends ApiController {

	protected $module_translation;

	protected $module_translation_service;

	protected $excel;

	public function __construct(
		ModuleTranslationRepositoryInterface $moduleTranslationRepositoryInterface,
		ModuleTranslationServices $moduleTranslationServices,
		ExcelServices $excelServices
	){
		$this->module_translation = $moduleTranslationRepositoryInterface;
		$this->module_translation_service = $moduleTranslationServices;
		$this->excel = $excelServices;
	}

	/**
	 * Add new translation by uploading csv file
	 * @param ModuleTranslationRequest $request
	 * @return mixed
	 */
	public function addModuleTranslation(ModuleTranslationRequest $request){

		//receive csv files only from upload
		$file = $request->file('file');

		$target_lang = $request->get('target_lang');

		//check target language already on the table, else ask admin-user to create 1.
		if(!$this->module_translation->checkLanguageAvailability($target_lang)){

			return $this->respondErrorMessage(2074);
		}

		//check csv file type
		if(!in_array($file->getClientMimeType(), config('futureed.accepted_csv'))){

			return $this->respondErrorMessage(2149);
		}

		// check if column is english(en) and target language(lang code)
		$header = ['module_id','en',$target_lang];

		$records = $this->excel->importCsv($file,$header);


		//parse csv files by 2 column row.
		$status = true;
		foreach($records as $data){

			//insert per row.
			$status = $this->module_translation->updatedTranslation($data,$target_lang);

			if(!$status){
				break;
			}
		}

		//return true else error message
		return ($status) ? $this->respondWithData(true) : $this->respondErrorMessage(2075);
	}

	/**
	 * Initialize translation for the specific language.
	 * @param $locale
	 * @return mixed
	 */
	public function generateNewLanguage($locale){

		//generate default languages.
		$this->module_translation->generateInitialLanguageTranslation($locale);

		return $this->respondWithData(true);
	}

	/**
	 * Check if langauge exist.
	 * @param $lang
	 * @return mixed
	 */
	public function checkLanguageAvailability($lang){

		return $this->respondWithData($this->module_translation->checkLanguageAvailability($lang));
	}

	/**
	 * Generate Translation File.
	 * @param $locale
	 * @return mixed
	 */
	public function generateTranslationFile($locale){

		//get module translation records
		$translations = $this->module_translation->getModuleTranslations($locale);

		//export files
		return $this->excel->exportCsv($translations,['module_id','en',$locale])->download('csv');

	}
}
