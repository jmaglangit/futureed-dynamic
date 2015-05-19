<?php	
	Routes::get('/', 'FutureLesson\Student\LoginController@index');

	Routes::group(['prefix' => '/student'], function()
	{
		Routes::get('/', 'FutureLesson\Student\LoginController@index');

		Routes::get('/registration', [
				'as' => 'student.registration'
				, 'uses' => 'FutureLesson\Student\LoginController@registration'
			]);
		Routes::get('/register/confirm', [
				'as' => 'student.login.confirm'
				, 'uses' => 'FutureLesson\Student\LoginController@registration'
			]);
		Routes::get('/password/forgot', [
				'as' => 'student.password.reset_code'
				, 'uses' => 'FutureLesson\Student\LoginController@reset_code'
			]);
		Routes::get('/logout', [ 
				'as' => 'student.logout'
				, 'uses' => 'FutureLesson\Student\LoginController@logout'
			]);
		Routes::post('/update-user-session', [ 
				'as' => 'student.update_user_session'
				, 'uses' => 'FutureLesson\Student\ProfileController@update_session'
			]);
		
		Routes::group([
			  'prefix' => '/login'], function()
		{
			Routes::get('/', [ 
					'as' => 'student.login'
					, 'uses' => 'FutureLesson\Student\LoginController@index'
				]);
			Routes::post('/process', [ 
					'as' => 'student.login.process'
					, 'uses' => 'FutureLesson\Student\LoginController@process'
				]);
			Routes::get('/forgot-password', [ 
					'as' => 'student.login.forgot_password'
					, 'uses' => 'FutureLesson\Student\LoginController@forgot_password'
				]);
			Routes::post('/reset-password', [ 
					'as' => 'student.login.reset_password'
					, 'uses' => 'FutureLesson\Student\LoginController@reset_password'
				]);
			
			Routes::post('/set-password', [ 
					'as' => 'student.login.set_password'
					, 'uses' => 'FutureLesson\Student\LoginController@reset_password'
				]);
		});

		Routes::group([
			  'prefix' => '/dashboard'
			, 'middleware' => 'student'], function()
		{
			Routes::get('/', [ 
					'as' => 'student.dashboard.index'
					, 'uses' => 'FutureLesson\Student\DashboardController@index'
				]);
			Routes::get('/follow-up-registration', [ 
					'as' => 'student.dashboard.follow_up_registration'
					, 'uses' => 'FutureLesson\Student\DashboardController@follow_up_registration'
				]);
		});

		Routes::group([
			  'prefix' => 'profile'
			, 'middleware' => 'student'], function()
		{
			Routes::get('/', [ 
					'as' => 'student.profile.index'
					, 'uses' => 'FutureLesson\Student\ProfileController@index'
				]);

			Routes::group(['prefix' => 'partials'], function() {
				Routes::get('/profile_form', [
						'as' => 'student.partials.profile_form'
						, 'uses' => 'FutureLesson\Student\ProfileController@profile_form'
					]);
				Routes::get('/edit_email_form', [
						'as' => 'student.partials.edit_email_form'
						, 'uses' => 'FutureLesson\Student\ProfileController@edit_email_form'
					]);
				Routes::get('/confirm_email_form', [
						'as' => 'student.partials.confirm_email_form'
						, 'uses' => 'FutureLesson\Student\ProfileController@confirm_email_form'
					]);
				Routes::get('/rewards_form', [
						'as' => 'student.partials.rewards_form'
						, 'uses' => 'FutureLesson\Student\ProfileController@rewards_form'
					]);
				Routes::get('/avatar_form', [
						'as' => 'student.partials.avatar_form'
						, 'uses' => 'FutureLesson\Student\ProfileController@avatar_form'
					]);
				Routes::get('/change_password_form', [
						'as' => 'student.partials.change_password_form'
						, 'uses' => 'FutureLesson\Student\ProfileController@change_password_form'
					]);
			});
		});

		Routes::group(['prefix' => 'partials'], function() {
			Routes::get('/base_url', [
					'as' => 'student.partials.base_url'
					, 'uses' => 'FutureLesson\Student\LoginController@base_url'
				]);
		});
	});
?>