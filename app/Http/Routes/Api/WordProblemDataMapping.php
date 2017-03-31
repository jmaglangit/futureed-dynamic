<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/31/17
 * Time: 2:20 PM
 */

Routes::group([
	'middleware' => ['api_user', 'api_after'],
	'permission' => ['admin', 'client', 'student'],
	'role' => ['principal', 'teacher', 'parent', 'admin', 'super admin']
],function(){

	Routes::resource('/word-problem-data','Api\v1\WordProblemDataMappingController',[
		'except' => ['edit','create']
	]);

});