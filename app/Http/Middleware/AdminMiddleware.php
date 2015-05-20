<?php namespace FutureEd\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class AdminMiddleware {

	public function handle($request, Closure $next)
	{
		$admin = Session::get('admin');

		if(!$admin){
			Session::flush();
			return redirect()->route('admin.login')->send();
		}

		$response = $next($request);

		return $response;
	}
}