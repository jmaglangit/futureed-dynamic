<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests\Api\LanguageRequest;
use FutureEd\Models\Repository\ModuleTranslation\ModuleTranslationRepositoryInterface;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class LanguageController extends ApiController {

	protected $module_translation;

	public function __construct(
		ModuleTranslationRepositoryInterface $moduleTranslationRepositoryInterface
	){
		$this->module_translation = $moduleTranslationRepositoryInterface;
	}

	/**
	 * @param $lang
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function setLanguage($lang)
	{
		if(!Session::has('appLanguage'))
		{
			Session::set('appLanguage', $lang);
		}
		else
		{
			Session::forget('appLanguage');
			Session::set('appLanguage', $lang);
		}

		Lang::setLocale(Session::get('appLanguage'));

		return back()->with('id', '');
	}

	/**
	 * Get all languages defined.
	 * @return mixed
	 */
	public function getLanguages(){

		//get config languages
		$languages = config('translatable.locales');

		//parse through out the languages if available.
		$available_lang = [];

		foreach($languages as $lang){
				array_push($available_lang,[
					'code' => $lang,
					'word' => trans('messages.' . $lang)
				]);
		}
		return $this->respondWithData($available_lang);
	}

	/**
	 * Initialize language throughout db tables.
	 * @param LanguageRequest $request
	 * @return mixed
	 * @internal param $locale
	 */
	public function initializeLanguage(LanguageRequest $request){

		$locale = $request->get('locale');

		//initialize module
		if(!$this->module_translation->checkLanguageAvailability($locale)){
			$this->module_translation->generateInitialLanguageTranslation($locale);
		}

		return $this->respondWithData(trans('messages.success_initialize_language'));
	}
}
