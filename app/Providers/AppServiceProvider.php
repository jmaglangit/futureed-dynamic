<?php namespace FutureEd\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		#TODO: Find a cleaner way for this
	
		Validator::extend('custom_password', function($attribute, $value, $parameters) {
			$valid = true;
			
			if (!preg_match("#[0-9]+#", $value)){
			
				$valid = false;
			
			}
			
			if(!preg_match("#[a-z]+#", $value)){
			
				$valid = false;
			
			}
			
			if(!preg_match("#[A-Z]+#", $value)){
			
				$valid = false;
				
			}
			
			if(!preg_match("#[\W ]+#", $value)){
			
				$valid = false;
				
			}
			
			return $valid;
		
		});
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
        $this->app->bind(
            'FutureEd\Models\Repository\Token\TokenRepositoryInterface',
            'FutureEd\Models\Repository\Token\TokenRepository'
        );
        $this->app->bind(
            'FutureEd\Models\Repository\School\SchoolRepositoryInterface',
            'FutureEd\Models\Repository\School\SchoolRepository'
        );
        $this->app->bind(
            'FutureEd\Models\Repository\Client\ClientRepositoryInterface',
            'FutureEd\Models\Repository\Client\ClientRepository'
        );
        $this->app->bind(
            'FutureEd\Models\Repository\Avatar\AvatarRepositoryInterface',
            'FutureEd\Models\Repository\Avatar\AvatarRepository'
        );
        $this->app->bind(
            'FutureEd\Models\Repository\Grade\GradeRepositoryInterface',
            'FutureEd\Models\Repository\Grade\GradeRepository'
        );
        $this->app->bind(
            'FutureEd\Models\Repository\Country\CountryRepositoryInterface',
            'FutureEd\Models\Repository\Country\CountryRepository'
        );
        $this->app->bind(
            'FutureEd\Models\Repository\Subject\SubjectRepositoryInterface',
            'FutureEd\Models\Repository\Subject\SubjectRepository'
        );
        $this->app->bind(
            'FutureEd\Models\Repository\Announcement\AnnouncementRepositoryInterface',
            'FutureEd\Models\Repository\Announcement\AnnouncementRepository'
        );
        $this->app->bind(
            'FutureEd\Models\Repository\Subscription\SubscriptionRepositoryInterface',
            'FutureEd\Models\Repository\Subscription\SubscriptionRepository'
        );
        $this->app->bind(
            'FutureEd\Models\Repository\ClientDiscount\ClientDiscountRepositoryInterface',
            'FutureEd\Models\Repository\ClientDiscount\ClientDiscountRepository'
        );
        $this->app->bind(
            'FutureEd\Models\Repository\SubjectArea\SubjectAreaRepositoryInterface',
            'FutureEd\Models\Repository\SubjectArea\SubjectAreaRepository'
        );
        $this->app->bind(
            'FutureEd\Models\Repository\VolumeDiscount\VolumeDiscountRepositoryInterface',
            'FutureEd\Models\Repository\VolumeDiscount\VolumeDiscountRepository'
        );
	}
}
