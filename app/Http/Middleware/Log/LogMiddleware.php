<?php namespace FutureEd\Http\Middleware\Log;

use Closure;
use FutureEd\Services\LogServices;
use FutureEd\Services\TokenServices;

class LogMiddleware {

	protected $token;

	protected $log_services;

	public function __construct(
		TokenServices $tokenServices,
		LogServices $logServices
	){

		$this->token = $tokenServices;

		$this->log_services = $logServices;
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

//		Log::info($request->server->all());
//		return $next($request);
		/*
		 * One log middleware for user, admin, and security
		 * check if has token, if not default to user
		 */
		$authorization  = $request->header('authorization');

		if($this->token->validateToken($authorization)){

			$payload = $this->token->getPayloadData();

			//get if user or admin
			$log_data = [
				'id' => $payload['id'],
				'type' => $payload['type'],
				'role' => $payload['role'],
				'page_accessed' => ($request->server('HTTP_REFERER'))
					? $request->server('HTTP_REFERER') : $request->server('REQUEST_URI'),
				'api_accessed' => ($request->server('SCRIPT_URI')) ? $request->server('SCRIPT_URI') : 'NA',
				'result_response' => ($request->server('REDIRECT_STATUS')) ? $request->server('REDIRECT_STATUS') : 'NA'
			];

			switch($payload['type']){

				case config('futureed.admin'):

					$log_response = $this->log_services->addAdminLog($log_data);

					break;

				default:

					$log_response = $this->log_services->addUserLog($log_data);

					break;
			}


		}else {

			//log as user with undefined values.

			$log_data = [
				'id' => 0,
				'username' => ($request->server('UNIQUE_ID')) ? $request->server('UNIQUE_ID') : 'NA',
				'page_accessed' => ($request->server('HTTP_REFERER'))
					? $request->server('HTTP_REFERER') : $request->server('REQUEST_URI'),
				'api_accessed' => ($request->server('REQUEST_URI')) ? $request->server('REQUEST_URI') : 'NA',
				'result_response' => ($request->server('REDIRECT_STATUS')) ? $request->server('REDIRECT_STATUS') : 'NA'
			];

			$log_response = $this->log_services->addUserLog($log_data);


		}

		//log security
		/*
		 *	user_id
		 * 	username
		 * 	client_ip
		 * 	client_port
		 * 	proxy_ip
		 * 	client_user_agent
		 * 	url
		 * 	result_response
		 * 	data_size_transferred
		 * 	log_type
		 * 	log_id
		 * 	status
		 *
		 */

		$security_log = [
			'user_id' => $log_response->user_id,
			'username' => $log_response->username,
			'client_ip' => ($request->server('REMOTE_ADDR')) ? $request->server('REMOTE_ADDR') : 'NA',
			'client_port' => ($request->server('REMOTE_PORT')) ? $request->server('REMOTE_PORT') : 'NA',
			'client_user_agent' => ($request->server('HTTP_USER_AGENT')) ? $request->server('HTTP_USER_AGENT') : 'NA',
			'url' => ($request->server('REQUEST_URI')) ? $request->server('REQUEST_URI') : 'NA',
			'result_response' => $log_response->result_response,
			'data_size_transferred' => memory_get_usage(),
			'log_type' => (isset($log_response->admin_type)) ? config('futureed.admin_log') : config('futureed.user_log'),
			'log_id' => $log_response->id,

		];


		$this->log_services->addSecurityLog($security_log);

		$response = $next($request);

		return $response;
	}

}
