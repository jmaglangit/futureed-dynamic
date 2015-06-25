<?php
Routes::resource('/order-detail','Api\v1\OrderDetailController', ['except' => ['create','edit']]);
Routes::group(['prefix' => '/order-detail'], function()
{
    Routes::get('/get-students/{order_id}', [
        'uses' => 'Api\v1\ParentStudentController@getStudents',
        'as' => 'order-detail.get.students']);
});