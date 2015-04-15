<?php	
	
	Routes::group(['prefix' => '/student'], function()
	{
		Routes::any('/', 'FutureLesson\Student\LoginController@index');
		Routes::get('/logout', [ 'as' => 'student.logout', 'uses' => 'FutureLesson\Student\LoginController@logout']);
	
		Routes::group(['prefix' => '/login'], function()
		{
			Routes::get('/', [ 'as' => 'student.login', 'uses' => 'FutureLesson\Student\LoginController@index']);
			Routes::match(['get','post'],'/enter-password', [ 'as' => 'student.enter_password', 'uses' => 'FutureLesson\Student\LoginController@enter_password']);
			Routes::get('/forgot-password', [ 'as' => 'student.login.forgot_password', 'uses' => 'FutureLesson\Student\LoginController@forgot_password']);
			Routes::match(['get','post'], '/forgot-password-success', [ 'as' => 'student.login.forgot_password_success', 'uses' => 'FutureLesson\Student\LoginController@forgot_password_success']);
			Routes::get('/reset-password', [ 'as' => 'student.login.reset_password', 'uses' => 'FutureLesson\Student\LoginController@reset_password']);
			Routes::post('/reset-confirm-password', [ 'as' => 'student.login.reset-confirm-password', 'uses' => 'FutureLesson\Student\LoginController@reset_confirm_password']);
			Routes::match(['get','post'], '/reset-password-success', [ 'as' => 'student.login.reset_password_success', 'uses' => 'FutureLesson\Student\LoginController@reset_password_success']);
		
			Routes::post('/process', [ 'as' => 'student.login.process', 'uses' => 'FutureLesson\Student\LoginController@process']);
		});

		Routes::group(['prefix' => '/dashboard'], function()
		{
			Routes::get('/', [ 'as' => 'student.dashboard.index', 'uses' => 'FutureLesson\Student\DashboardController@index']);
			Routes::get('/follow-up-registration', [ 'as' => 'student.dashboard.follow_up_registration', 'uses' => 'FutureLesson\Student\DashboardController@follow_up_registration']);
			Routes::get('/my-profile', [ 'as' => 'student.dashboard.my_profile', 'uses' => 'FutureLesson\Student\DashboardController@my_profile']);
		});
		
		Routes::get('/registration', ['as' => 'student.registration', 'uses' => 'FutureLesson\Student\LoginController@registration']);
		Routes::get('/registration-success', ['as' => 'student.registration-success', 'uses' => 'FutureLesson\Student\LoginController@registration_success']);
	});
?>