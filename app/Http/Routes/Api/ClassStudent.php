<?php 
Routes::group(['prefix' => '/class-student'], function()
{
    Routes::post('/add-existing-student', [
                'uses' => 'Api\v1\ClassStudentController@addExistingStudent',
                'as' => 'class-student.add.existing.student']);
    Routes::post('/add-new-student', [
    'uses' => 'Api\v1\ClassStudentController@addNewStudent',
    'as' => 'class-student.add.new.student']);
});