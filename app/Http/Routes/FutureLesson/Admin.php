<?php 
	Routes::group(['prefix' => '/admin'], function()
	{
		Routes::get('/', 'FutureLesson\Admin\LoginController@index');
		Routes::get('/password/reset',[
				'as' => 'admin.password.reset'
				, 'uses' => 'FutureLesson\Admin\LoginController@forgotPass'
			]);
		

		Routes::group(['prefix' => '/login'], function()
		{
			Routes::get('/', [
					'as' => 'admin.login'
					, 'uses' => 'FutureLesson\Admin\LoginController@index'
				]);
			Routes::get('/forgot-password', [
					'as' => 'admin.login.forgot_password'
					, 'uses' => 'FutureLesson\Admin\LoginController@forgotPass'
				]);
			/*change this to post (for template viewing only)*/
			Routes::get('/reset-password', [
					'as' => 'admin.login.reset_password'
					, 'uses' => 'FutureLesson\Admin\LoginController@resetPass'
				]);
		});
	});
?>
