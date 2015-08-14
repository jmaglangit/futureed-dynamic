<?php
Routes::group([
	'prefix' => '/parent-student',
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client'],
	'role' => ['principal','teacher','parent','admin','super admin']
], function()
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

    Routes::put('/pay-subscription/{id}', [
        'uses' => 'Api\v1\ParentStudentController@paySubscription',
        'as' => 'parent-student.pay.subscription']);
    Routes::delete('/delete-student-by-parent-id/{id}', [
        'uses' => 'Api\v1\ParentStudentController@deleteStudentByParentId',
        'as' => 'parent-student.delete.student.by.parent.id']);

    Routes::post('/add-students-by-email', [
        'uses' => 'Api\v1\ParentStudentController@addStudentByEmail',
        'as' => 'parent-student.add.student.by.email']);

    Routes::post('/add-students-by-username', [
        'uses' => 'Api\v1\ParentStudentController@addStudentByName',
        'as' => 'parent-student.add.student.by.username']);

	Routes::delete('/{id}',[
		'uses' => 'Api\v1\ParentStudentController@destroy',
		'as' => 'api.v1.parent-student.destroy'
	]);

});


Routes::group([
	'prefix' => '/client/manage',
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client'],
	'role' => ['principal','teacher','parent','admin','super admin']
], function()
{
    Routes::resource('/student','Api\v1\ClientStudentController',
        ['except' => ['create','edit']]);

    //NOTE:student confirm his/her invitation via teacher
    Routes::put('/update-student/{id}', [
        'uses' => 'Api\v1\TeacherStudentController@studentRegistrationAfterInvitation',
        'as' => 'client-manage.update.student']);

    Routes::get('/view-student/{id}', [
        'uses' => 'Api\v1\TeacherStudentController@viewStudentDetailsByToken',
        'as' => 'client-manage.update.student']);

    Routes::put('/email/student/{id}', [
        'uses' => 'Api\v1\StudentEmailController@updateStudentEmail',
        'as' => 'parent-student.email.student']);

});

