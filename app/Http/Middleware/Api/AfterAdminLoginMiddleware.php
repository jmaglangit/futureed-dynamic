<?php namespace FutureEd\Http\Middleware\Api;

use Closure;
use FutureEd\Models\Repository\Admin\AdminRepositoryInterface;
use FutureEd\Services\SessionServices;
use FutureEd\Services\TokenServices;
use Illuminate\Http\Response;

class AfterAdminLoginMiddleware extends JWTMiddleware{

	protected $admin;

	protected $token;

	protected $session;

	public function __construct(
		TokenServices $tokenServices,
		AdminRepositoryInterface $adminRepositoryInterface,
		SessionServices $sessionServices
	){

		$this->admin = $adminRepositoryInterface;

		$this->token = $tokenServices;

		$this->session = $sessionServices;
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
		$response =  $next($request);

		$content = json_decode($response->getContent());

		if(isset($content->data)){

			//Add jwt token
			$token = $this->getToken([
				'id' => $content->data->id,
				'type' => config('futureed.admin'),
				'role' => $this->admin->getAdminRole($content->data->id)
			]);


			//TODO: check if token has expired empty
			//TODO: Add session token, last_activity to users table.

			$user_data = [
				'user_id' => $this->admin->getAdminUserId($content->data->id),
				'session_token' => session('_token')
			];

			if(!$this->session->addSessionToken($user_data)){

				return $this->setStatusCode(Response::HTTP_OK)->respondErrorMessage(2060);
			}

			$headers = $response->headers;

			$headers->set('authorization',$token);

			$response->headers = $headers;

			return $response;


		}else {

			return $response;
		}
	}

}
