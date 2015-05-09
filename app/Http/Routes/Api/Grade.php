<?php

//grade
Routes::resource('/grade','Api\v1\GradeController',
    ['except' => ['create','edit']]);
