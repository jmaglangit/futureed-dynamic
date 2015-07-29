<?php

Routes::resource('/event','Api\v1\EventController',
	['except' => ['create','edit']]);