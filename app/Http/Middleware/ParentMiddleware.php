<?php namespace FutureEd\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException as NotFoundHttpException;
use Illuminate\Support\Facades\Session;

class ParentMiddleware {

    public function handle($request, Closure $next)
    {
        $parent = Session::get('Parent');

        if(!$parent) {
            throw new NotFoundHttpException;
        }

        $response = $next($request);

        $response->headers->set("Cache-Control","no-cache,no-store, must-revalidate");
        $response->headers->set("Pragma", "no-cache"); //HTTP 1.0
        $response->headers->set("Expires"," Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

        return $response;
    }
}