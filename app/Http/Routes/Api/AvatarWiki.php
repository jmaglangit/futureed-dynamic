<?php

Routes::get('/avatar-wiki',[
	'uses' => 'Api\v1\AvatarWikiController@getAvatarWikiByAvatarId',
	'as' => 'api.v1.avatar-wiki'
]);