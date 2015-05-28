<?php

Routes::group(['prefix' => '/school'], function()
{
	//search school
	Routes::get('/search','Api\v1\SchoolSearchController@schoolSearch');

});

//schools
Routes::resource('/school','Api\v1\SchoolController',
    ['except' => ['create','edit']]);
