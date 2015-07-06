<?php

Routes::resource('/age-group','Api\v1\AgeGroupController',
	['only' => 'index']);