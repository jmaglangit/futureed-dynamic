<?php

//Client
Routes::resource('/client','Api\v1\ClientController',
    ['except' => ['create','edit']]);

//Parent
Routes::resource('/client/parent','Api\v1\ClientParentController',
    ['except' => ['create','edit']]);
Routes::get('client/parent/student/list/{id}','Api\v1\ClientParentController@getStudentList');

//Principal
Routes::resource('/client/principal','Api\v1\ClientPrincipalController',
    ['except' => ['create','edit']]);

//Teacher
Routes::resource('/client/teacher','Api\v1\ClientTeacherController',
    ['except' => ['create','edit']]);

//client
Routes::post('/client/login','Api\v1\ClientLoginController@login');
Routes::post('/client/register','Api\v1\ClientRegisterController@register');
Routes::post('/client/password/{id}','Api\v1\ClientPasswordController@changePassword');
