<?php namespace FutureEd\Http\Middleware\Api;

use Closure;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Services\SessionServices;
use FutureEd\Services\TokenServices;
use Illuminate\Http\Response;

class AfterClientLoginMiddleware extends JWTMiddleware {

	protected $client;

	protected $token;

	protected $session;

	public function __construct(
		ClientRepositoryInterface $clientRepositoryInterface,
		TokenServices $tokenServices,
		SessionServices $sessionServices
	){
		$this->client = $clientRepositoryInterface;

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
				'type' => config('futureed.client'),
				'role' => $this->client->getClientRole($content->data->id)
			]);


			//TODO: check if token has expired empty
			//TODO: Add session token, last_activity to users table.

			$user = $this->client->getClientDetails($content->data->id);

			$user_data = [
				'user_id' => $user->user_id,
				'session_token' => session('_token')
			];

			if(!$this->session->addSessionToken($user_data)){

				return $this->setStatusCode(Response::HTTP_OK)->respondErrorMessage(2061);
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
