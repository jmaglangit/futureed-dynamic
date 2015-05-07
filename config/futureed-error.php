<?php


return [

     'error_messages' => [
        //Field error codes
        1001 => "Required field not found.",
        1002 => "Required field empty.",



        //Rules messages
        2001 => 'User does not exists.',
        2002 =>  'Email does not exists.',
        2003 => 'Account does not exists.',


        //for student error message
        2004 => 'Username and picture password is incorrect.',
        2005 => 'Country does not exist.',
        2006 => 'Confirmation code does not match.',
        2007 => 'Confirmation code has expired.',
        2008 => 'The email/username you entered is invalid. Please try inputting again. If the account you are attempting to login is for a student less than 13 yrs old, please login via the parent site',
        2009 => 'Avatar does not exists',
        2010 => 'Parent does not exists',
        2011 => 'Username and password is incorrect',
        2012 => 'Picture password is incorrect',
        2013 => 'Username or Email is invalid',
        2014 => 'Your account has been locked.',
        2015 => 'Confirmation code is required.',
        2016 => 'Confirmation code should be number only.',
        2017 => 'Picture Password is required',
        2018 => 'Username does not exist',
        2019 => 'Username or Email is invalid or your account has been locked. Please click forgot password to reset your password.',
        2020 => 'Account is deleted',
        2021 => 'Username is invalid.',


        2100 => 'Invalid reset code',
        2101 => 'Invalid password image',
        2102 => 'Access token expired',
        2103 => 'Invalid confirmation code',
        2104 => 'Username already exists',
        2105 => "School Code doesn't exists",
        2106 => 'Email does not match',
        2107 => 'Your current email and new email are the same.',
        2108 => 'New Email does not exists',
        2109 => 'Your account has already been confirmed.',
        2110 => 'You have already setup the forgot password steps.',
        2111 => 'You have already setup the email confirmation steps.',


        // Client Error messages
        2200 => 'Email already exists',
        2201 => 'Username already exists',
        2202 => 'School Name already exists',

        //account status messages
        2230 => 'Account is inactive',
        2231 => 'Account Locked',
        2232 => 'Account Deleted',

        // login error messages
        2233 => 'Invalid Password',

        2234 => 'Unauthorized Registration',

    ],
];