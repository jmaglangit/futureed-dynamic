<?php


return [

    'error_code' => [
        '1007' => 'Not Found!',
        '1008' => 'The email/username you entered is invalid Please try inputting again. If the account you are attempting to login is for a student less than 13 yrs old, please login via the parent site',
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
        
        2100 => 'Invalid reset code',
        2101 => 'Invalid password image',
        2102 => 'Access token expired',
        2103 => 'Invalid confirmation code',


       


];