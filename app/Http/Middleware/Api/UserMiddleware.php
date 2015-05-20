<?php namespace FutureEd\Http\Middleware\Api;

use Closure;

class UserMiddleware extends JWTMiddleware{

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
     * @param  array  $user_type
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        return $next($request);

        $authorization  = $request->header('authorization');

        $this->validateToken($authorization);

        if($this->getMessageBag()){

            return $this->respondWithError($this->getMessageBag());
        }

        //initialize futureed config
        $futureed = config('futureed');

        //get permissions
        $action = $request->route()->getAction();

        //get payload
        $payload = $this->getPayload();

        // check if payload type exist in permissions else respond unauthorized.
        if(!in_array(strtolower($payload['type']),$action['permission'],true)){

            return $this->respondErrorMessage(2032);
        }

        //get role
       // if payload type is client get role
        if($payload['type'] == $futureed['client'] && in_array(strtolower($payload['role']),$action['role'])){

            dd('imba');
        }
        // compare payload role if exist in route role else respond unauthorized.



	}

}
