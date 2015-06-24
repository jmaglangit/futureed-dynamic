<?php
Routes::group(['prefix' => '/order-detail'], function()
{
    Routes::get('/get-students/{order_id}', [
        'uses' => 'Api\v1\ParentStudentController@getStudents',
        'as' => 'order-detail.get.students']);
});