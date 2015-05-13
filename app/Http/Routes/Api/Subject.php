<?php

//Subjects
Routes::resource('/subject','Api\v1\SubjectController', ['except' => ['create','edit']]);
