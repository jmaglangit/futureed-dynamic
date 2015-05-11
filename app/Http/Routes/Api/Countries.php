<?php

//countries
Routes::resource('/countries','Api\v1\CountryController',
    ['except' => ['create','edit']]);
