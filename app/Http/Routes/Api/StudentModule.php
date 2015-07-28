<?php Routes::resource('/student-module','Api\v1\StudentModuleController', ['only' => ['store']]);
      Routes::put('/reset/student-module/{id}', [
		'uses' => 'Api\v1\AdminStudentModuleController@resetStudentModule',
		'as' => 'reset.student-module']);

