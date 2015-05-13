<?php 

Routes::resource('/announcement','Api\v1\AnnouncementController',['except'=>['create','edit']]);
