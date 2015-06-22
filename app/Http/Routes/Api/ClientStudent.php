<?php
Routes::group(['prefix' => '/parent-student'], function()
{
    Routes::post('/add-existing-student', [
        'uses' => 'Api\v1\ParentStudentController@addExistingStudent',
        'as' => 'parent-student.add.existing.student']);

    Routes::post('/confirm-student', [
        'uses' => 'Api\v1\ParentStudentController@parentConfirmStudent',
        'as' => 'parent-student.confirm.student']);

    Routes::put('/update-student/{id}', [
        'uses' => 'Api\v1\ParentStudentController@parentUpdateStudent',
        'as' => 'parent-student.update.student']);

    Routes::get('/get-students/{id}', [
        'uses' => 'Api\v1\ParentStudentController@getStudents',
        'as' => 'parent-student.get.student']);
    Routes::post('/pay-subscription', [
        'uses' => 'Api\v1\ParentStudentController@paySubscription',
        'as' => 'parent-student.pay.subscription']);
    Routes::delete('/delete-student-by-parent-id/{id}', [
        'uses' => 'Api\v1\ParentStudentController@deleteStudentByParentId',
        'as' => 'parent-student.delete.student.by.parent.id']);

});

Routes::resource('/parent-student','Api\v1\ParentStudentController', ['only' => ['destroy']]);

Routes::group(['prefix' => '/client/manage'], function()
{
    Routes::resource('/student','Api\v1\ClientStudentController',
        ['except' => ['create','edit']]);

    //NOTE:student confirm his/her invitation via teacher
    Routes::put('/update-student/{id}', [
        'uses' => 'Api\v1\TeacherStudentController@studentRegistrationAfterInvitation',
        'as' => 'client-manage.update.student']);

    Routes::post('/view-student/{id}', [
        'uses' => 'Api\v1\TeacherStudentController@viewStudentDetailsByToken',
        'as' => 'client-manage.update.student']);

    Routes::put('/email/student/{id}', [
        'uses' => 'Api\v1\StudentEmailController@updateStudentEmail',
        'as' => 'parent-student.email.student']);


});

