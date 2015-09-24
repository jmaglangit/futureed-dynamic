<?php namespace FutureEd\Http\Middleware\Api;

use Closure;
use FutureEd\Models\Repository\Admin\AdminRepositoryInterface;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Services\TokenServices;

class AfterAutoLoginMiddleware extends JWTMiddleware {

	protected $client;

	protected $admin;

	protected $token;

	/**
	 * @param ClientRepositoryInterface $clientRepositoryInterface
	 * @param AdminRepositoryInterface $adminRepositoryInterface
	 * @param TokenServices $tokenServices
	 */
	public function __construct(
		ClientRepositoryInterface $clientRepositoryInterface,
		AdminRepositoryInterface $adminRepositoryInterface,
		TokenServices $tokenServices
	) {

		$this->client = $clientRepositoryInterface;

		$this->admin = $adminRepositoryInterface;

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



			$headers = $response->headers;

			$headers->set('authorization',$token);

			$response->headers = $headers;

			return $response;


		}else {

			return $response;
		}

	}

}
