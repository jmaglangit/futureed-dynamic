<?php namespace FutureEd\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class StudentMiddleware {

    public function handle($request, Closure $next)
    {
    	$student = Session::get('student');

    	if(!$student) {
			return redirect()->route('student.login')->send();
		}

        $response = $next($request);

        $response->headers->set("Cache-Control","no-cache,no-store, must-revalidate");
    	$response->headers->set("Pragma", "no-cache"); //HTTP 1.0
    	$response->headers->set("Expires"," Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    	
        return $response;
    }
}