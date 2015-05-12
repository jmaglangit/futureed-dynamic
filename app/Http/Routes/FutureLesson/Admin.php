<?php 
	Routes::group(['prefix' => '/admin'], function()
	{
		Routes::get('/', [
			'as' => 'admin'
			, 'uses' => 'FutureLesson\Admin\LoginController@index'
		]);
	});
?>
