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
        2005 => 'Country does not exist',
        2006 => 'Confirmation code does not match.',
        2007 => 'Confirmation code has expired.',
        2008 => 'The email/username you entered is invalid. Please try inputting again. If the account you are attempting to login is for a student less than 13 yrs old, please login via the parent site',
        2009 => 'Avatar does not exist',
        2010 => 'Parent does not exist',
        2011 => 'Username and password is incorrect',
        2012 => 'Picture password is incorrect',
        2013 => 'Username or Email is invalid',
        
        2100 => 'Invalid reset code',
        2101 => 'Invalid password image',
        2102 => 'Access token expired',
        2103 => 'Invalid confirmation code',
        2104 => 'Username already exist',
        2105 => "School Code doesn't exist",

        // Client Error messages
        2200 => 'Email already exist',
        2201 => 'Username already exist',
        2202 => 'School Name already exist',

        //account status messages
        2230 => 'Account Inactive',
        2231 => 'Account Locked',
        2232 => 'Account Deleted',

        // login error messages
        2233 => 'Invalid Password',

        2234 => 'Unauthorized Registration',

    ],
];