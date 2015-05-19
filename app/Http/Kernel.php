<?php namespace FutureEd\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
		'Illuminate\Cookie\Middleware\EncryptCookies',
		'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
		'Illuminate\Session\Middleware\StartSession',
		'Illuminate\View\Middleware\ShareErrorsFromSession',
		'FutureEd\Http\Middleware\VerifyCsrfToken',
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth' => 'FutureEd\Http\Middleware\Authenticate',
		'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
		'student' => 'FutureEd\Http\Middleware\StudentMiddleware',		
		'client' => 'FutureEd\Http\Middleware\ClientMiddleware',
        'jwt' => 'FutureEd\Http\Middleware\Api\JWTMiddleware',
        'api_user' => 'FutureEd\Http\Middleware\Api\UserMiddleware',
        'api_admin' => 'FutureEd\Http\Middleware\Api\AdminMiddleware',
        'api_student' => 'FutureEd\Http\Middleware\Api\StudentMiddleware',
        'api_client' => 'FutureEd\Http\Middleware\Api\ClientMiddleware',
        'api_client_principal' => 'FutureEd\Http\Middleware\Api\ClientPrincipalMiddleware',
        'api_client_parent' => 'FutureEd\Http\Middleware\Api\ClientParentMiddleware',
        'api_client_teacher' => 'FutureEd\Http\Middleware\Api\ClientTeacherMiddleware',
	];

}
