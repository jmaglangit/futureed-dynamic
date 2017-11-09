<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/15/17
 * Time: 5:32 PM
 */

Routes::group([
	'middleware' => ['api_user', 'api_after'],
	'permission' => ['admin', 'client', 'student'],
	'role' => ['principal', 'teacher', 'parent', 'admin', 'super admin']
],function(){

	Routes::resource('/data-library','Api\v1\DataLibraryController',[
		'except' => ['edit','create']
	]);

});