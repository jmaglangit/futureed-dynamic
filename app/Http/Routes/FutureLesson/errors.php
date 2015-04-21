<?php

	Routes::group(['prefix' => '/error'], function() 
	{
		Routes::get('/404', ['as' => 'error.404', 'uses' => 'FutureLesson\Error\ErrorsController@error_404']);
		Routes::get('/405', ['as' => 'error.405', 'uses' => 'FutureLesson\Error\ErrorsController@error_405']);
		Routes::get('/500', ['as' => 'error.500', 'uses' => 'FutureLesson\Error\ErrorsController@error_500']);
	});
?>