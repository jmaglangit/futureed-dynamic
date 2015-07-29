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
        'jwt' => 'FutureEd\Http\Middleware\Api\JWTMiddleware',
        'api_user' => 'FutureEd\Http\Middleware\Api\UserMiddleware',
        'api_after' => 'FutureEd\Http\Middleware\Api\AfterMiddleware',

//		'parent' => 'FutureEd\Http\Middleware\ParentMiddleware',
//		'principal' => 'FutureEd\Http\Middleware\PrincipalMiddleware',
//		'teacher' => 'FutureEd\Http\Middleware\TeacherMiddleware',
//		'admin_partial' => 'FutureEd\Http\Middleware\AdminPartialsMiddleware',
//		'student_partial' => 'FutureEd\Http\Middleware\StudentPartialsMiddleware'
	];

}
