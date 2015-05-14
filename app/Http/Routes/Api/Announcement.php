<?php 

Routes::group(['prefix' => '/announcement'], function()
{
	Routes::get('/','Api\v1\AnnouncementController@show');
	Routes::post('/update','Api\v1\AnnouncementController@update');
});
