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
        $response =  $next($request);
//        return $response;

        $authorization  = $request->header('authorization');


        //if authorization exist then extract id, type, and role
        if($authorization){
            $this->token->parseToken($authorization);

            $payload_data = $this->getPayload();

            $token = $this->getToken([
                'id' => $payload_data['id'],
                'type' => $payload_data['type'],
                'role' => $payload_data['role'],
            ]);
            //parse payload data ang extract id, type, and role and insert to getToken()


            $collection = $response->headers;

            $collection->set('authorization',$token);

            $response->headers = $collection;

        }


        return $response;
	}




}
