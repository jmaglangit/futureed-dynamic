<?php

Routes::resource('/student-point', 'Api\v1\StudentPointController',
	['except' => ['create', 'edit']]);


Routes::resource('admin/student/point', 'Api\v1\AdminStudentPointController',
	['except' => ['create', 'edit']]);

