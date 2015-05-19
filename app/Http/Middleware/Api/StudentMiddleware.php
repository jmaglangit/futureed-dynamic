<?php namespace FutureEd\Http\Middleware\Api;

use Closure;

class StudentMiddleware extends JWTMiddleware{

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

        //get token payload
        $student_payload = $this->getPayload();

        //check type if student
        if($student_payload['type'] == config('futureed.student')){

            return $next($request);
        }

        //check type if admin
        if($student_payload['type'] == config('futureed.admin')){

            return $next($request);
        }

        //check type if parent
        if($student_payload['type'] == config('futureed.client')){

            return $next($request);
        }

        return $this->respondErrorMessage(2032);

	}

}
