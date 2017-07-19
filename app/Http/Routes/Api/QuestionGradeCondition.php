<?php
//getConditionByGradeId

	Routes::get('/grade/question-condition/{grade_id}',[
		'as' => 'api.v1.grade.question-condition',
		'uses' => 'Api\v1\QuestionGradeConditionController@getConditionByGradeId'
	]);

