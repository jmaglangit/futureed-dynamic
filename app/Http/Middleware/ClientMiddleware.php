<?php namespace FutureEd\Http\Middleware;

use Closure;

class ClientMiddleware {

    public function handle($request, Closure $next)
    {
    	if(!\Session::get('user')) {
			return redirect()->route('client.login')->send();
		}

        $response = $next($request);
        return $response;
    }
}