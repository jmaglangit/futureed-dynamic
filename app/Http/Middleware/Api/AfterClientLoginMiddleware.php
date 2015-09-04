<?php namespace FutureEd\Http\Middleware\Api;

use Closure;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Services\TokenServices;

class AfterClientLoginMiddleware extends JWTMiddleware {

	protected $client;

	protected $token;

	public function __construct(
		ClientRepositoryInterface $clientRepositoryInterface,
		TokenServices $tokenServices
	){
		$this->client = $clientRepositoryInterface;

		$this->token = $tokenServices;

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

			$headers = $response->headers;

			$headers->set('authorization',$token);

			$response->headers = $headers;

			return $response;


		}else {

			return $response;
		}
	}

}
