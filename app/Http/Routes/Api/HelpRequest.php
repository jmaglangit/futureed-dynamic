<?php Routes::resource('/help-request','Api\v1\HelpRequestController',
    ['except' => ['create','edit']]);