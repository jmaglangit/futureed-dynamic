<?php

Routes::resource('/background-image','Api\v1\BackgroundImageController',
	['only' => ['index','show']]);