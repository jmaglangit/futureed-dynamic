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

Routes::group(['prefix' => '/classroom'], function()
{
    Routes::delete('/delete-classroom-by-order-no/{order_no}', [
        'uses' => 'Api\v1\ClassroomController@deleteClassroomByOrderNo',
        'as' => 'classroom.delete.delete-classroom-by-order-no']);

    Routes::put('/update-invoice-classroom/{id}', [
        'uses' => 'Api\v1\ClassroomController@update',
        'as' => 'classroom.update.invoice-classroom']);

    Routes::get('/get-classroom-by-order-no/{order_no}', [
        'uses' => 'Api\v1\ClassroomController@getClassroomByOrderNo',
        'as' => 'classroom.update.invoice-classroom']);

});
