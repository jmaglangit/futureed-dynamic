<?php namespace FutureEd\Http\Controllers\Api\v1;

use Carbon\Carbon;
use FutureEd\Http\Controllers\Api\Traits\TranslationTrait;
use FutureEd\Models\Repository\ModuleTranslation\ModuleTranslationRepositoryInterface;
use FutureEd\Services\ExcelServices;
use FutureEd\Http\Requests\Api\ModuleTranslationRequest;
use FutureEd\Services\ErrorMessageServices as Error;
use Illuminate\Support\Facades\Artisan;

class ModuleTranslationController extends ApiController {

	use TranslationTrait;

	protected $excel;

	/**
	 * @param ModuleTranslationRepositoryInterface $moduleTranslationRepositoryInterface
	 * @param ExcelServices $excelServices
	 * @internal param ModuleRepositoryInterface $moduleRepositoryInterface
	 */
	public function __construct(
		ModuleTranslationRepositoryInterface $moduleTranslationRepositoryInterface,
		ExcelServices $excelServices
	){
		$this->model = $moduleTranslationRepositoryInterface;
		$this->excel = $excelServices;
		$this->translatable_model = config('futureed.translatable_models.module');
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
		if(!$this->model->checkLanguageAvailability($target_lang)){

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
			$status = $this->model->updatedTranslation($data,$target_lang,config('futureed.module_manual_translated.name'));

			if(!$status){
				break;
			}
		}

		//return true else error message
		return ($status) ? $this->respondWithData(trans('messages.success_trans_upload'))
			: $this->respondErrorMessage(Error::MODULE_TRANSLATION_UPDATE_FAIL);
	}

	/**
	 * Generate Translation File.
	 * @param $locale
	 * @return mixed
	 */
	public function generateTranslationFile($locale){

		//check if locale language code exists
		if(!$this->model->checkLanguageAvailability($locale)){
			return $this->respondErrorMessage(Error::MODULE_TRANSLATION_LOCALE);
		}

		//get module translation records
		$translations = $this->model->getModuleTranslations($locale);

		//export files
		$filename = config('futureed.module_translation_two_column') . '_'.config('translatable.fallback_locale') . '_'
			. $locale . '_' . Carbon::now()->toDateString();

		return $this->excel->exportCsv($translations,$filename)->download('csv');

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
		$fields = $this->model->getTranslatedAttributes();

		if(!in_array($input['field'],$fields)){
			return $this->respondErrorMessage(Error::LANGUAGE_FIELD_NOT_AVAILABLE);
		}

		//Queue translation
		// -m module --language {lang} -f {field} --tagged {tagged|boolean}
		Artisan::queue('fl:google-translate',[
			'--model' => $this->translatable_model,
			'--language' => $input['target_lang'],
			'--field' => $input['field'],
			'--tagged' => $input['tagged']
		]);

		return $this->respondWithData(trans('messages.queue_trans_google'));
	}
}
