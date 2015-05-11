<?php

//schools
Routes::resource('/school','Api\v1\SchoolController',
    ['except' => ['create','edit']]);
