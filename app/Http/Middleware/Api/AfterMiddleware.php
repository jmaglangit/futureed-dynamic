<?php namespace FutureEd\Http\Middleware\Api;

use Closure;

class AfterMiddleware extends JWTMiddleware{

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

//        $authorization  = $request->header('authorization');
//
//        $this->validateToken($authorization);
//
//        if($this->getMessageBag()){
//
//            return $this->respondWithError($this->getMessageBag());
//        }

//        dd($this->getPayload());




        $response =  $next($request);
//        dd($response);
//        $collection = $response->headers;
//        $collection->set('authodrization','dasfdasf');
////        dd($collection);
//        $response->headers = $collection;

//        dd($response);
//        if($response->headers->get('content-type') == 'application/json')
//        {
//            $collection = $response->original;
//            $collection->put('timestamp',Carbon::now()->timestamp);
//            $response->setContent($collection);
//        }

        return $response;
	}




}
