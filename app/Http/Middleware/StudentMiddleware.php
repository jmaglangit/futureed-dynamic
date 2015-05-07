<?php namespace FutureEd\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class StudentMiddleware {

    public function handle($request, Closure $next)
    {
    	$student = Session::get('student');

    	if(!$student) {
    		Session::flush();
			return redirect()->route('student.login')->send();
		}

        $response = $next($request);
        return $response;
    }
}