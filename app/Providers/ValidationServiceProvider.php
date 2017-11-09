<?php namespace FutureEd\Providers;

use FutureEd\Services\ValidationReplacerServices;
use FutureEd\Services\ValidationServices;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{

		Validator::resolver(function($translator, $data, $rules, $messages)
		{
			return new ValidationServices($translator, $data, $rules, $messages);
		});
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{



	}

}
