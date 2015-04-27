<?php


return [
    'error_messages' => [
        //Field error codes
        1001 => "Required field not found.",
        1002 => "Required field empty.",



        //Rules messages
        2001 => 'User does not exist.',
        2002 =>  'Email does not exist.',
        2003 => 'Account does not exist.',

        //for student error message
        2004 => 'Username and picture password is incorrect',
        2008 => 'The email/username you entered is invalid Please try inputting again. If the account you are attempting to login is for a student less than 13 yrs old, please login via the parent site',
<<<<<<< HEAD

        // Client Error messages
        2200 => 'Email already exist',
        2201 => 'Username already exist',
        2202 => 'School Name already exist',
=======
        
        2100 => 'Reset code invalid',
        2101 => 'Password image invalid',
        2102 => 'Access token expire',
>>>>>>> 1d1c5eb58c3128f5628c9df2f3ea135840f190c6
    ],
];