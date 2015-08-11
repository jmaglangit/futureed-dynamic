<?php namespace FutureEd\Http\Middleware\Api;

use Closure;
use FutureEd\Models\Repository\Admin\AdminRepositoryInterface;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Services\TokenServices;

class UserMiddleware extends JWTMiddleware{

	protected $student;

	protected $client;

	protected $admin;

	protected $token;

	public function __construct(
		StudentRepositoryInterface $studentRepositoryInterface,
		ClientRepositoryInterface $clientRepositoryInterface,
		AdminRepositoryInterface $adminRepositoryInterface,
		TokenServices $tokenServices
	){

		$this->student = $studentRepositoryInterface;

		$this->client = $clientRepositoryInterface;

		$this->admin = $adminRepositoryInterface;

		$this->token = $tokenServices;
	}

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

        $authorization  = $request->header('authorization');

		$this->validateToken($authorization);


        if($this->getMessageBag()){

            return $this->respondWithError($this->getMessageBag());
        }

		//TODO: CHECK user if it has right access.

		//check id by user type
		//if client and admin, check role.
		$payload_data = $this->token->getPayloadData();

		if($this->checkUser($payload_data['id'],$payload_data['type'],$payload_data['role'])){

			//Authorized access.
			return $next($request);
		} else {

			//unauthorize access.
			return $this->respondErrorMessage(2032);
		}

	}

	/**
	 * Check User if has required access level.
	 * @param $id
	 * @param $user_type
	 * @param $user_role
	 * @return bool
	 */
	public function checkUser($id, $user_type, $user_role){

		switch($user_type){

			case config('futureed.student'):

				$response = $this->student->getStudent($id);

				$return = ($response <> null) ? true : false;

				break;

			case config('futureed.client'):

				$response = $this->client->getClient($id,$user_role);

				$return = ($response <> null) ? true : false;
				break;

			case config('futureed.admin'):

				$response = $this->admin->getAdmin($id,$user_role);

				$return = ($response <> null) ? true : false;
				break;

			default:

				$return = false;
				break;
		}

		return $return;
	}





}
