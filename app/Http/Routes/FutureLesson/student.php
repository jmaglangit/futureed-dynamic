<?php	
	
	Routes::group(['prefix' => '/student'], function()
	{
		Routes::get('/', 'FutureLesson\Student\LoginController@index');
		Routes::get('/registration', [
				'as' => 'student.registration'
				, 'uses' => 'FutureLesson\Student\LoginController@registration'
			]);
		Routes::get('/email/confirm', [
				'as' => 'student.login.confirm'
				, 'uses' => 'FutureLesson\Student\LoginController@registration'
			]);
		Routes::get('/password/reset', [
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
			$base = 'FutureLesson\Student';

			Routes::get('/', [ 
					'as' => 'student.profile.index'
					, 'uses' => $base . '\ProfileController@index'
				]);
			Routes::get('/rewards', [
					'as' => 'student.profile.rewards'
					, 'uses' => $base . '\ProfileController@rewards'
				]);
			Routes::get('/change-password', [
					'as' => 'student.profile.change_password'
					, 'uses' => $base . '\ProfileController@change_password'
				]);
			Routes::get('/change-avatar', [
					'as' => 'student.profile.change_avatar'
					, 'uses' => $base . '\ProfileController@change_avatar'
				]);
			Routes::get('/edit-email', [
					'as' => 'student.profile.edit_email'
					, 'middleware' => 'student'
					, 'uses' => $base . '\ProfileController@edit_email'
				]);
		});
	});
?>