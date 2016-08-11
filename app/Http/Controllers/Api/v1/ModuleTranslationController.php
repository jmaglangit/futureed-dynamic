<?php namespace FutureEd\Http\Controllers\Api\v1;

use Carbon\Carbon;
use FutureEd\Http\Requests;
use FutureEd\Models\Repository\ModuleTranslation\ModuleTranslationRepositoryInterface;
use FutureEd\Services\ExcelServices;
use FutureEd\Http\Requests\Api\ModuleTranslationRequest;
use FutureEd\Services\ErrorMessageServices as Error;

class ModuleTranslationController extends ApiController {

	protected $module_translation;

	protected $excel;

	public function __construct(
		ModuleTranslationRepositoryInterface $moduleTranslationRepositoryInterface,
		ExcelServices $excelServices
	){
		$this->module_translation = $moduleTranslationRepositoryInterface;
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

			return $this->respondErrorMessage(Error::MODULE_TRANSLATION_LOCALE);
		}

		//check csv file type
		if(!in_array($file->getClientMimeType(), config('futureed.accepted_csv'))){

			return $this->respondErrorMessage(2149);
		}

		// check if column is english(en) and target language(lang code)
		$header = ['module_id',config('futureed.language_default'),$target_lang];

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
		return ($status) ? $this->respondWithData(true) : $this->respondErrorMessage(Error::MODULE_TRANSLATION_UPDATE_FAIL);
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

		//check if locale language code exists
		if(!$this->module_translation->checkLanguageAvailability($locale)){
			return $this->respondErrorMessage(Error::MODULE_TRANSLATION_LOCALE);
		}

		//get module translation records
		$translations = $this->module_translation->getModuleTranslations($locale);

		//export files
		$filename = config('futureed.module_translation_two_column') . '_'.config('futureed.language_default') . '_'
			. $locale . '_' . Carbon::now()->toDateString();

		return $this->excel->exportCsv($translations,$filename)->download('csv');

	}
}
