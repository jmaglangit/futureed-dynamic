<?php

Routes::resource('/student-point', 'Api\v1\StudentPointController',
	['except' => ['create', 'edit']]);