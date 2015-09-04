<?php namespace FutureEd\Http\Middleware\Api;

use Closure;
use FutureEd\Models\Repository\Admin\AdminRepositoryInterface;
use FutureEd\Services\TokenServices;

class AfterAdminLoginMiddleware extends JWTMiddleware{

	protected $admin;

	protected $token;

	public function __construct(
		TokenServices $tokenServices,
		AdminRepositoryInterface $adminRepositoryInterface
	){

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
		$response =  $next($request);

		$content = json_decode($response->getContent());

		if(isset($content->data)){

			//Add jwt token
			$token = $this->getToken([
				'id' => $content->data->id,
				'type' => config('futureed.admin'),
				'role' => $this->admin->getAdminRole($content->data->id)
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
