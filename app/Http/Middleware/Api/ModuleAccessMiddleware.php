<?php namespace FutureEd\Http\Middleware\Api;

use Closure;
use FutureEd\Services\StudentServices;
use FutureEd\Services\TokenServices;

class ModuleAccessMiddleware extends JWTMiddleware{

	protected $student_services;

	protected $token;


	public function __construct(
		StudentServices $studentServices,
		TokenServices $tokenServices
	){
		$this->student_services = $studentServices;
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

		$authorization  = $request->header('authorization');

		$this->token->validateToken($authorization);


		if($this->getMessageBag()){

			return $this->respondWithError($this->getMessageBag());
		}

		$payload_data = $this->token->getPayloadData();

		if($payload_data['type'] == config('futureed.student')){

			//get variable of module



			if($request->route()->getName() == 'api.v1.module.show'){

				$module_id = $request->route()->getParameter('module');
				$student_id = $payload_data['id'];

				//check if student has access to module.
				$is_valid = $this->student_services->checkStudentValidModule($student_id,$module_id);

				if(!$is_valid){

					return $this->respondErrorMessage(2070);
				}

			}

		}
		return $next($request);
	}

}
