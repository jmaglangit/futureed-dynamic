<?php

Routes::resource('/avatar-pose', 'Api\v1\AvatarPoseController',
	['only' => ['index']]);
