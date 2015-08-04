<?php

Routes::resource('/quote', 'Api\v1\QuoteController',
	['only' => ['index']]);
