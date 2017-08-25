<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 8/24/17
 * Time: 1:23 PM
 */

Routes::group([
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','client','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
],function(){

	Routes::resource('/question-template-operation','Api\v1\QuestionTemplateOperationController',
		['except' => ['create','edit']]);
});