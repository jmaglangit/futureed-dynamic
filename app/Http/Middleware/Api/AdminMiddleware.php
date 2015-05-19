<?php namespace FutureEd\Http\Middleware\Api;

use Closure;

class AdminMiddleware extends JWTMiddleware{

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

        $authorization = $request->header('authorization');

        $this->validateToken($authorization);

        //check if token is valid.
        if($this->getMessageBag()){

            return $this->respondWithError($this->getMessageBag());
        }

        $admin_payload = $this->getPayload();

        //check type if admin
        if($admin_payload['type'] == config('futureed.admin')){

            return $next($request);
        }

		return $this->errorMessage(2032);
	}

}
