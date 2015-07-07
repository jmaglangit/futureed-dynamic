<?php

Routes::resource('/teaching-content','Api\v1\TeachingContentController',
	['except' => ['create', 'edit']]);

