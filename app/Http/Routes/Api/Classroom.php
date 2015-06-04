<?php


Routes::group(['prefix' => '/classroom/{id}'], function(){

    Routes::get('/students',[
        'uses' => 'Api\v1\ClassroomStudentController@show'
    ]);
});

/**
 * Classroom resource routes
 */
Routes::group(['middleware' => 'api_user'],function(){



    Routes::resource('/classroom','Api\v1\ClassroomController',
        ['except' => ['create','edit']]);


});
