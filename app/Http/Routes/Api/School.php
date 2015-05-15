<?php

//schools
Routes::resource('/school','Api\v1\SchoolController',
    ['except' => ['create','edit']]);


Routes::group(['prefix' => '/school'], function()
{
//search school
Routes::Post('/search','Api\v1\SchoolSearchController@schoolSearch');


});
