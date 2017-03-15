<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/15/17
 * Time: 11:43 AM
 */

Routes::group([
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin'],
	'role' => ['admin','super admin']
], function(){

	Routes::resource('/question-template', 'Api\v1\QuestionTemplateController',
		['except' => ['create', 'edit']]);
});