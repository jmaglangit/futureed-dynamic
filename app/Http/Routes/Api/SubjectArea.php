<?php

//Subjects
Routes::resource('/subject-area','Api\v1\SubjectAreaController', ['except' => ['create','edit']]);
