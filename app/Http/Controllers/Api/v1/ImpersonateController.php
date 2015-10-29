<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;

use FutureEd\Models\Repository\Admin\AdminRepositoryInterface;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
use FutureEd\Services\SessionServices;
use FutureEd\Http\Requests\Api\ImpersonateRequest;

class ImpersonateController extends ApiController {

	/**
	 * Impersonator
	 *
	 * - get user details to impersonate
	 * - log user with impersonators token.
	 * - output similar to user login
	 */

	// Create session for login users.
	// Create middleware for impersonator

	protected $session;

	protected $user;

	protected $student;

	protected $client;

	protected $admin;

	/**
	 * @param SessionServices $sessionServices
	 * @param UserRepositoryInterface $userRepositoryInterface
	 * @param StudentRepositoryInterface $studentRepositoryInterface
	 * @param ClientRepositoryInterface $clientRepositoryInterface
	 * @param AdminRepositoryInterface $adminRepositoryInterface
	 */
	public function __construct(
		SessionServices $sessionServices,
		UserRepositoryInterface $userRepositoryInterface,
		StudentRepositoryInterface $studentRepositoryInterface,
		ClientRepositoryInterface $clientRepositoryInterface,
		AdminRepositoryInterface $adminRepositoryInterface
	){
		$this->session = $sessionServices;

		$this->user = $userRepositoryInterface;

		$this->student = $studentRepositoryInterface;

		$this->client = $clientRepositoryInterface;

		$this->admin = $adminRepositoryInterface;
	}

	/**
	 * Impersonate login return user details.
	 * @param ImpersonateRequest $request
	 * @return mixed
	 * @internal param $id
	 */
	public function impersonateLogin(ImpersonateRequest $request){


		//impersonate user.

		$user = $this->user->getUser($request->get('id'));

		//update user with session token and last activity.
		//rules applies if user has been logged in.


		$user_data = [
			'user_id' => $user->id,
			'session_token' => session('_token')
		];

		//enable impersonate
		$this->user->enableImpersonate($user->id, session('current_user'));

		switch($user->user_type){

			case config('futureed.student'):

				$response =  (!$this->session->addSessionToken($user_data))
					? 2060
					: $this->student->getStudent(
						$this->student->getStudentId($user->id)
					);

				break;

			case config('futureed.client'):

				$response = (!$this->session->addSessionToken($user_data))
					? 2061
					: $this->client->getClientDetails(
						$this->client->getClientId($user->id)
					);
				break;

			case config('futureed.admin'):

				$response = (!$this->session->addSessionToken($user_data))
					? 2062
					: $this->admin->getAdminDetail(
						$this->admin->getAdminId($user->id)
					);

				break;

			default:

				$response = 0;
				break;

		}


		if(is_object($response) && session('current_user')){

			return $this->respondWithData($response);
		} else {

			return $this->respondErrorMessage($response);
		}


	}

	/**
	 * Impersonate logout return impersonators details.
	 * @param ImpersonateRequest $request
	 * @return bool
	 * @internal param $id
	 */
	public function impersonateLogout(ImpersonateRequest $request){

		$id = $request->get('id');

		$impersonator = $this->user->getImpersonator($id);

		$admin = $this->user->getUser($impersonator);

		if($this->user->emptySessionToken($id)
			&& $this->user->disabledImpersonate($id)){

			//return impersonator details.

			return $this->respondWithData(
				$admin
			);
		} else {

			return $this->respondWithData(false);

		}

	}



}
