<?php namespace FutureEd\Http\Middleware\Api;

use Closure;
use FutureEd\Http\Controllers\Api\Traits\ErrorMessageTrait;
use FutureEd\Http\Controllers\Api\Traits\MessageBagTrait;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
use FutureEd\Services\TokenServices;
use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class JWTMiddleware {

    use MessageBagTrait;
    use ErrorMessageTrait;

    /**
     * Token implementation
     *
     * @var token
     */
    protected $token;

    protected $user;

    protected $status_code = Response::HTTP_UNAUTHORIZED;

    /**
     * @param TokenServices $tokenServices
     * @param UserRepositoryInterface $userRepositoryInterface
     */
    public function __construct (
		TokenServices $tokenServices,
		UserRepositoryInterface $userRepositoryInterface
	){

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
     * get token
     * @return mixed
     */
    public function getToken($payload){

        return $this->token->getToken($payload);
    }

    public function getPayload(){

        return $this->token->getPayloadData();
    }

    /**
     * @return mixed
     */
    public function getStatusCode() {
        return $this->status_code;
    }

    /**
     * @param mixed $status_code
     */
    public function setStatusCode($status_code) {
        $this->status_code = $status_code;
        return $this;
    }



    /**
     * validate token
     *
     * @param $token
     * @return int
     */
    public function validateToken($token){

        $error_msg = trans('errors');

        $validator = Validator::make(
            [
                'authorization' => $token
            ],
            [
                'authorization' => 'required'
            ],
            [
                'required' => $error_msg[2030]
            ]
        );

        if($validator->fails()){

            $validator_msg = $validator->messages()->toArray();

            $return = $this->setErrorCode(2030)
                ->setField('authorization')
                ->setMessage($validator_msg["authorization"][0])
                ->errorMessage();

            $this->addMessageBag($return);

            return 0;
        }

		//Validate Token
        $token_result = $this->token->validateToken($token);

        if(!$token_result){

            $return = $this->setErrorCode(2029)
                ->setField('authorization')
                ->setMessage($error_msg[2029])
                ->errorMessage();

            $this->addMessageBag($return);
        }

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
                'status' => $this->getStatusCode(),
                'errors' => $message
            ]
        );

    }

    /**
     * return error message based on the error_code
     *
     * @param $error_code
     * @return JWTMiddleware
     */
    public function respondErrorMessage($error_code){
        $error_msg  = trans('errors');

        if(!is_null($error_code)){

            $return = $this->setErrorCode($error_code)
                ->setMessage($error_msg[$error_code])
                ->errorMessageCommon();


            $this->addMessageBag($return);

            return $this->respondWithError($this->getMessageBag());
        }

    }


}
