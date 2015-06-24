<?php
Routes::group(['prefix' => '/order-detail'], function()
{
    Routes::get('/get-students/{order_id}', [
        'uses' => 'Api\v1\ParentStudentController@getStudents',
        'as' => 'parent-student.get.students']);
});