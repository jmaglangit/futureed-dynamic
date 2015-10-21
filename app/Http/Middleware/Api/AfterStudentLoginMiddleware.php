<?php namespace FutureEd\Http\Middleware\Api;

use Closure;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Services\SessionServices;
use FutureEd\Services\TokenServices;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class AfterStudentLoginMiddleware extends JWTMiddleware{

	protected $session;

	protected $token;

	protected $student;

	public function __construct(
		SessionServices $sessionServices,
		TokenServices $tokenServices,
		StudentRepositoryInterface $studentRepositoryInterface
	){
		$this->session = $sessionServices;
		$this->token = $tokenServices;
		$this->student = $studentRepositoryInterface;
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
				'type' => config('futureed.student'),
				'role' => 0
			]);


			//TODO: check if token has expired empty

			//TODO: Add session token, last_activity to users table.

			$user_data = [
				'user_id' => $content->data->user->id,
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
