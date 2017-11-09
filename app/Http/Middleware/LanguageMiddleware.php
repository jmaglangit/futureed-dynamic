<?php namespace FutureEd\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if(Session::has('appLanguage'))
		{
			App::setLocale(Session::get('appLanguage'));
		}
		else
		{
			App::setLocale('en');
		}

		return $next($request);
	}

}
