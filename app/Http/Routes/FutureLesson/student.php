<?php	
	
	Routes::group(['prefix' => '/student'], function()
	{
		Routes::get('/', 'FutureLesson\Student\LoginController@index');
	
		Routes::group(['prefix' => '/login'], function()
		{
			Routes::get('/', [ 'as' => 'student.login', 'uses' => 'FutureLesson\Student\LoginController@index']);
			Routes::get('/enter-password', [ 'as' => 'student.enter_password', 'uses' => 'FutureLesson\Student\LoginController@enter_password']);
			Routes::get('/forgot-password', [ 'as' => 'student.login.forgot_password', 'uses' => 'FutureLesson\Student\LoginController@forgot_password']);
			Routes::get('/forgot-password-success', [ 'as' => 'student.login.forgot_password_success', 'uses' => 'FutureLesson\Student\LoginController@forgot_password_success']);
			Routes::get('/reset-password', [ 'as' => 'student.login.reset_password', 'uses' => 'FutureLesson\Student\LoginController@reset_password']);
			Routes::get('/reset-confirm-password', [ 'as' => 'student.login.reset-confirm-password', 'uses' => 'FutureLesson\Student\LoginController@reset_confirm_password']);
			Routes::get('/reset-password-success', [ 'as' => 'student.login.reset_password_success', 'uses' => 'FutureLesson\Student\LoginController@reset_password_success']);
			
		});
		
		Routes::get('/registration', ['as' => 'student.registration', 'uses' => 'FutureLesson\Student\LoginController@registration']);
		Routes::get('/registration-success', ['as' => 'student.registration-success', 'uses' => 'FutureLesson\Student\LoginController@registration_success']);
	});
?>