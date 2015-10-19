<?php namespace FutureEd\Http\Middleware\Api;

use Closure;
use FutureEd\Models\Repository\Admin\AdminRepositoryInterface;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Services\SessionServices;
use FutureEd\Services\TokenServices;

class AfterAutoLoginMiddleware extends JWTMiddleware {

	protected $client;

	protected $admin;

	protected $token;

	protected $session;

	/**
	 * @param ClientRepositoryInterface $clientRepositoryInterface
	 * @param AdminRepositoryInterface $adminRepositoryInterface
	 * @param TokenServices $tokenServices
	 * @param SessionServices $sessionServices
	 */
	public function __construct(
		ClientRepositoryInterface $clientRepositoryInterface,
		AdminRepositoryInterface $adminRepositoryInterface,
		TokenServices $tokenServices,
		SessionServices $sessionServices
	) {

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
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		//Get user_type
		$request_data = $request->all();

		$response =  $next($request);

		$content = json_decode($response->getContent());

		if(isset($content->data)){

			switch($request_data['user_type']){

				case config('futureed.student'):

					//Add jwt token
					$token = $this->getToken([
						'id' => $content->data->id,
						'type' => config('futureed.student'),
						'role' => 0
					]);

					break;

				case config('futureed.client'):

					//Add jwt token
					$token = $this->getToken([
						'id' => $content->data->id,
						'type' => config('futureed.client'),
						'role' => $this->client->getClientRole($content->data->id)
					]);

					break;

				case config('futureed.admin'):

					//Add jwt token
					$token = $this->getToken([
						'id' => $content->data->id,
						'type' => config('futureed.admin'),
						'role' => $this->admin->getAdmin($content->data->id)
					]);

					break;

				default:

					$token = $this->getToken([
						'id' => $content->data->id
					]);
					break;
			}

			//TODO: check if token has expired empty
			//TODO: Add session token, last_activity to users table.
			$user_data = [
				'user_id' => $content->data->user->id,
				'session_token' => session('_token')
			];

			if(!$this->session->addSessionToken($user_data)){

				return $this->respondErrorMessage(2060);
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
