<?php namespace FutureEd\Http\Middleware\Api;

use Closure;
use FutureEd\Models\Repository\Admin\AdminRepositoryInterface;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Services\TokenServices;
use FutureEd\Services\SessionServices;

class UserMiddleware extends JWTMiddleware{

	protected $student;

	protected $client;

	protected $admin;

	protected $token;

	protected $session;

	public function __construct(
		StudentRepositoryInterface $studentRepositoryInterface,
		ClientRepositoryInterface $clientRepositoryInterface,
		AdminRepositoryInterface $adminRepositoryInterface,
		TokenServices $tokenServices,
		SessionServices $sessionServices
	){

		$this->student = $studentRepositoryInterface;

		$this->client = $clientRepositoryInterface;

		$this->admin = $adminRepositoryInterface;

		$this->token = $tokenServices;

		$this->session = $sessionServices;
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

		//get actions
		$routes_actions = $request->route()->getAction();

		//Validate actions.
		$user_validate = $this->validateAction($payload_data['type'],$payload_data['role'], $routes_actions);

		//Validate user
		$user_check = $this->checkUser($payload_data['id'],$payload_data['type'],$payload_data['role']);

		if($user_check && $user_validate){

			//Add session user
			$this->session->getUserInformation($payload_data['id'],$payload_data['type']);
			$this->session->addSessionUser();

			//Authorized access.
			return $next($request);
		} else {

			//unauthorized access.
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

				$response = $this->client->getClientDetails($id,$user_role);

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

	/**
	 * Validate user actions.
	 * @param $user_type
	 * @param $user_role
	 * @param $action
	 * @return bool
	 */
	public function validateAction($user_type, $user_role, $action){


		$action_type = $action['permission'];
		$action_role = (isset($action['role']))? $action['role'] : [] ;

		switch($user_type){

			case config('futureed.student'):

				$return = (in_array(strtolower($user_type),$action_type))? true : false;
				break;

			case config('futureed.client'):

				$return = (in_array(strtolower($user_type),$action_type) && in_array(strtolower($user_role),$action_role))
					? true : false ;
				break;

			case config('futureed.admin'):

				$return = (in_array(strtolower($user_type),$action_type) && in_array(strtolower($user_role),$action_role))
					? true : false ;
				break;

			default:

				$return = false;
				break;
		}

		return $return;

	}





}
