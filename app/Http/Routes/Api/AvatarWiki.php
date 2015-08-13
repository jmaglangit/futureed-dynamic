<?php

Routes::get('/avatar-wiki',[
	'uses' => 'Api\v1\AvatarWikiController@getAvatarWikiByAvatarId',
	'as' => 'api.v1.avatar-wiki',
	'middleware' => ['api_user','api_after'],
	'permission' => ['admin','user','student'],
	'role' => ['principal','teacher','parent','admin','super admin']
]);