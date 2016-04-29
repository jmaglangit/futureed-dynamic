<?php namespace FutureEd\Http\Controllers\Api\v1;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class LanguageController extends ApiController
{
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
}
