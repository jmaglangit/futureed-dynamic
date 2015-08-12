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
		'admin' => 'FutureEd\Http\Middleware\AdminMiddleware',
		'client' => 'FutureEd\Http\Middleware\ClientMiddleware',

		//API MIDDLEWARE
        'jwt' => 'FutureEd\Http\Middleware\Api\JWTMiddleware',
        'api_user' => 'FutureEd\Http\Middleware\Api\UserMiddleware',
        'api_after' => 'FutureEd\Http\Middleware\Api\AfterMiddleware',
		'api_after_student_login' => 'FutureEd\Http\Middleware\Api\AfterStudentLoginMiddleware',
		'api_after_client_login' => 'FutureEd\Http\Middleware\Api\AfterClientLoginMiddleware',
		'api_after_admin_login' => 'FutureEd\Http\Middleware\Api\AfterAdminLoginMiddleware'
	];

}
