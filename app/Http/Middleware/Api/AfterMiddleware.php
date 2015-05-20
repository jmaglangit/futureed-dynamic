<?php namespace FutureEd\Http\Middleware\Api;

use Closure;
use Symfony\Component\HttpFoundation\JsonResponse;

class AfterMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        $response =  $next($request);

//        $input = $request->header();
//        $request->merge(['authorization' => 'qwertykeys']);
//
//
////        dd($response);
        return $response;
	}

}
