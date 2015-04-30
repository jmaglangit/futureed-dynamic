<?php namespace FutureEd\Http\Middleware;

use Closure;

class StudentMiddleware {

    public function handle($request, Closure $next)
    {
    	if(!\Session::get('user')) {
			return redirect()->route('student.login')->send();
		}

        $response = $next($request);
        return $response;
    }
}