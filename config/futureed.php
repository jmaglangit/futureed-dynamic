<?php

return [
    'login' => [
        'attempt' => 3
    ],
    'activated' => 1,
    'deleted' => 0,
    'locked' => 0,
    'image_password_count' => 3,
    'image_password_folder' => 'images/password',


    //Request code expiry in seconds
    'request_code_expiry' => 3600,

    //User types
    'admin' => 'Admin',
    'client' => 'Client',
    'student' => 'Student',
    
    //avatar folder 
    'image_avatar_folder' => 'images/avatar',
    'image_avatar_count' => 5,

];