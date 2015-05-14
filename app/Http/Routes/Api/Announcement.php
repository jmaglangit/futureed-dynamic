<?php 
Routes::resource('/announcement','Api\v1\AnnouncementController', ['only' => ['index','store']]);