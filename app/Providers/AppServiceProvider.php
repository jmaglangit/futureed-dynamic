<?php namespace FutureEd\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'FutureEd\Services\Registrar'
		);
        $this->app->bind(
            'FutureEd\Models\Repository\User\UserRepositoryInterface',
            'FutureEd\Models\Repository\User\UserRepository'
        );
        $this->app->bind(
            'FutureEd\Models\Repository\Validator\ValidatorRepositoryInterface',
            'FutureEd\Models\Repository\Validator\ValidatorRepository'
        );
        $this->app->bind(
            'FutureEd\Models\Repository\PasswordImage\PasswordImageRepositoryInterface',
            'FutureEd\Models\Repository\PasswordImage\PasswordImageRepository'
        );
        $this->app->bind(
            'FutureEd\Models\Repository\Student\StudentRepositoryInterface',
            'FutureEd\Models\Repository\Student\StudentRepository'
        );
        $this->app->bind(
            'FutureEd\Models\Repository\Admin\AdminRepositoryInterface',
            'FutureEd\Models\Repository\Admin\AdminRepository'
        );


	}

}
