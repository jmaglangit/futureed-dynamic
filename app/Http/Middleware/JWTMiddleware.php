<?php namespace FutureEd\Http\Middleware;

use Closure;
use FutureEd\Http\Controllers\Api\Traits\AccessTokenTrait;
use FutureEd\Http\Controllers\Api\Traits\ErrorMessageTrait;
use FutureEd\Http\Controllers\Api\Traits\MessageBagTrait;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
use FutureEd\Services\TokenServices;
use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Http\Response;

class JWTMiddleware implements Middleware{

    use MessageBagTrait;
    use ErrorMessageTrait;
    use AccessTokenTrait;
    /**
     * Token implementation
     *
     * @var token
     */
    protected $token;

    /**
     * Create new token instance
     *
     * @param TokenServices $tokenServices
     */
    public function __construct (TokenServices $tokenServices, UserRepositoryInterface $userRepositoryInterface){

        $this->token = $tokenServices;
        $this->user = $userRepositoryInterface;
    }

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{


        //get token if validated.
        $authorization = $request->header('authorization');


        $this->validateToken($authorization);


        if($this->getMessageBag()){

           return $this->respondWithError($this->getMessageBag());
        }

        return $next($request);

	}


    /**
     * Returns json format of the errors. COPY from API Controller
     *
     * @param  array data
     * @return json
     */
    public function respond($data){

        return Response()->json($data);

    }

    /**
     * Format the error response. COPY from API Controller
     *
     * @param  mixed  $message
     * @return $this->respond
     */
    public function respondWithError($message = 'Not Found!') {

        return $this->respond(
            [
                'status' => Response::HTTP_OK,
                'errors' => $message
            ]
        );

    }


}
