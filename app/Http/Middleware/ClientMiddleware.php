<?php namespace FutureEd\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class ClientMiddleware {

    public function handle($request, Closure $next)
    {
    	$client = Session::get('client');

    	if(!$client) {
			return redirect()->route('client.login')->send();
		}

        $response = $next($request);
        return $response;
    }
}