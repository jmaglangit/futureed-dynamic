<?php namespace FutureEd\Http\Controllers\Api\v1;

use Carbon\Carbon;
use FutureEd\Models\Repository\Module\ModuleRepositoryInterface;
use FutureEd\Models\Repository\ModuleTranslation\ModuleTranslationRepositoryInterface;
use FutureEd\Services\ExcelServices;
use FutureEd\Http\Requests\Api\ModuleTranslationRequest;
use FutureEd\Services\ErrorMessageServices as Error;
use FutureEd\Services\GoogleTranslateServices;
use Illuminate\Support\Facades\App;

class ModuleTranslationController extends ApiController {

	protected $module_translation;

	protected $excel;

	protected $google_translate;

	protected $module;

	public function __construct(
		ModuleTranslationRepositoryInterface $moduleTranslationRepositoryInterface,
		ModuleRepositoryInterface $moduleRepositoryInterface,
		ExcelServices $excelServices,
		GoogleTranslateServices $googleTranslateServices
	){
		$this->module_translation = $moduleTranslationRepositoryInterface;
		$this->excel = $excelServices;
		$this->google_translate = $googleTranslateServices;
		$this->module = $moduleRepositoryInterface;
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
		$header = ['module_id',config('translatable.fallback_locale'),$target_lang];

		$records = $this->excel->importCsv($file,$header);

		// check if target language is correctly set.
		if(!isset($records[0][$target_lang])){
			return $this->respondErrorMessage(Error::LANGUAGE_NOT_AVAILABLE);
		}

		//parse csv files by 2 column row.
		$status = true;
		foreach($records as $record){

			//insert per row.
			$data = [
				'module_id' => $record->module_id,
				'string' => $record->{$target_lang}
			];
			$status = $this->module_translation->updatedTranslation($data,$target_lang,config('futureed.module_manual_translated.name'));

			if(!$status){
				break;
			}
		}

		//return true else error message
		return ($status) ? $this->respondWithData(trans('messages.success_trans_upload'))
			: $this->respondErrorMessage(Error::MODULE_TRANSLATION_UPDATE_FAIL);
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
	 * Check if language exist.
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
		$filename = config('futureed.module_translation_two_column') . '_'.config('translatable.fallback_locale') . '_'
			. $locale . '_' . Carbon::now()->toDateString();

		return $this->excel->exportCsv($translations,$filename)->download('csv');

	}

	/**
	 * Ger available languages
	 * @return mixed
	 */
	public function getLanguageTranslation(){

		//get config languages
		$languages = config('translatable.locales');

		//parse through out the languages if available.
		$available_lang = [];

		foreach($languages as $lang){
			if($this->module_translation->checkLanguageAvailability($lang)){
				array_push($available_lang,[
					'code' => $lang,
					'word' => trans('messages.' . $lang)
				]);
			}
		}

		return $this->respondWithData($available_lang);
	}

	/**
	 * Get translatable fields defined by the model.
	 * @return mixed
	 */
	public function getTranslatedAttributes(){

		$fields = $this->module_translation->getTranslatedAttributes();

		// add manual translation indicators.
		$data = [];

		foreach($fields as $field){
			array_push($data,[
				'field' => $field,
				'auto' => (in_array($field,config('futureed.module_manual_translated'))) ? 0 : 1
			]);
		}

		return $this->respondWithData($data);
	}

	/**
	 * Translate fields using Google translate.
	 * @param ModuleTranslationRequest $request
	 * @return mixed
	 */
	public function googleTranslate(ModuleTranslationRequest $request){

		//check if input has translate only flagged or all.
		$input = $request->only(
			'target_lang',
			'field',
			'tagged'
		);

		//check if field exist for manual translation
		if(in_array($input['field'],config('futureed.module_manual_translated'))){
			return $this->respondErrorMessage(Error::LANGUAGE_FIELD_NOT_AVAILABLE);
		}

		//check if field is for google translate
		$fields = $this->module_translation->getTranslatedAttributes();

		if(!in_array($input['field'],$fields)){
			return $this->respondErrorMessage(Error::LANGUAGE_FIELD_NOT_AVAILABLE);
		}

		//loop on every 1000 rows, or translate by batch
		$offset = 0;
		$limit = config('futureed.seeder_record_limit');

		$current_lang = App::getLocale();

		for($i=0; $i <= ceil($this->module_translation->moduleCount()/$limit);$i++){

			App::setLocale(config('translatable.fallback_locale'));

			$module = $this->module_translation->getModules([],$limit,$offset);
			$offset += $limit;

			//parse to array and add translations to target_language
			foreach($module['records'] as $record){

				//check if translatable and tagged
				$translable = 0;
				if($input['tagged'] == config('futureed.true')
					&& $record['translatable'] == config('futureed.true')){

					$translable++;

				} elseif($input['tagged'] == config('futureed.false')){

					//if all are translatable
					$translable++;
				}

				if($translable == config('futureed.true')){

					// set target language
					$this->google_translate->setTarget($input['target_lang']);

					// get translation using google translate.
					$translated_text = $this->google_translate->translate($record[$input['field']]);

					$data = [
						'module_id' => $record['id'],
						'string' => $translated_text
					];

					$this->module_translation->updatedTranslation($data,$input['target_lang'],$input['field']);

					//update translatable tag to 0 on module
					$this->module->updateModule($record['id'],[
						'translatable' => config('futureed.false')
					]);

				}
			}
		}

		//get back the previous locale
		App::setLocale($current_lang);

		return $this->respondWithData(trans('messages.success_trans_google'));
	}
}
