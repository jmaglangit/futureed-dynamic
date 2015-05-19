<?php namespace FutureEd\Http\Middleware\Api;

use Closure;

class UserMiddleware extends JWTMiddleware{

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

        $authorization  = $request->header('authorization');

        $this->validateToken($authorization);

        if($this->getMessageBag()){

            return $this->respondWithError($this->getMessageBag());
        }

		return $next($request);
	}

}
