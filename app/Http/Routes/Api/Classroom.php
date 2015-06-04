<?php

/**
 * Classroom resource routes
 */
Routes::group(['middleware' => 'api_user'],function(){

    Routes::resource('/classroom','Api\v1\ClassroomController',
        ['except' => ['create','edit']]);

});
