<?php	
	
	Routes::group(['prefix' => '/student'], function()
	{
		Routes::get('/', 'FutureLesson\Student\LoginController@index');
	
		Routes::group(['prefix' => '/login'], function()
		{
			Routes::get('/', [ 'as' => 'student.login', 'uses' => 'FutureLesson\Student\LoginController@index']);
			Routes::get('/forgot-password', [ 'as' => 'student.login.forgot_password', 'uses' => 'FutureLesson\Client\LoginController@forgot_password']);
			Routes::get('/forgot-password-success', [ 'as' => 'student.login.forgot_password_success', 'uses' => 'FutureLesson\Client\LoginController@forgot_password_success']);
			Routes::get('/reset-password', [ 'as' => 'student.login.reset_password', 'uses' => 'FutureLesson\Client\LoginController@reset_password']);
			Routes::get('/reset-password-success', [ 'as' => 'student.login.reset_password_success', 'uses' => 'FutureLesson\Client\LoginController@reset_password_success']);
			
		});
	});
?>