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
        2004 => 'Username and picture password is incorrect.',
        2005 => 'Country does not exist.',
        2006 => 'Confirmation code does not match.',
        2007 => 'Confirmation code has expired.',
        2008 => 'The Username or Email you entered is invalid. Please try inputting again. If the account you are attempting to login is for a student less than 13 yrs old, please login via the parent site.',
        2009 => 'Avatar does not exist.',
        2010 => 'Parent does not exist.',
        2011 => 'Username and password is incorrect.',
        2012 => 'Picture password is incorrect.',
        2013 => 'Username or Email is invalid.',
        2014 => 'Your Account has been locked. Please go to the forgot password screen to reset your password.',
        2015 => 'Confirmation code is required.',
        2016 => 'Confirmation code should be number only.',
        2017 => 'Picture Password is required.',
        2018 => 'Username does not exist.',
        2019 => 'Username or Email is invalid or your account has been locked. Please click forgot password to reset your password.',
        2020 => 'Account is deleted.',
        2021 => 'Username is invalid.',
        2022 => 'The school level field is required.',
        2023 => 'The school level field should be number only.',
        2024 => 'Confirmation code is invalid.',
        2025 => 'Reset code is required.',
        2026 => 'Reset code should be number only.',
        2027 => 'Reset code is invalid.',
        2028 => 'The Student has to be 13 years old or above to be able to register.',
        2029 => 'Access authentication failure.',
        2030 => 'Access authorization is required.',
        2031 => 'Access authorization is invalid.',

        2100 => 'Reset code is invalid.',
        2101 => 'Password image is invalid.',
        2102 => 'Access token expired.',
        2103 => 'Confirmation code is invalid.',
        2104 => 'Username already exists.',
        2105 => 'School does not exist.',
        2106 => 'Email does not match.',
        2107 => 'Your current email and new email are the same.',
        2108 => 'New Email does not exist.',
        2109 => 'Your account has already been confirmed.',
        2110 => 'You have already setup the forgot password steps.',
        2111 => 'You have already setup the email confirmation steps.',
        2112 => 'Password should be alpha numeric with lowercase letters, uppercase letters, numerical and special punctuation.',
        2113 => 'Username and password is invalid.',
        2114 => 'Your password is incorrect.',
        2115 => 'Your contact number must be this format +00 (000) 000-0000.',
        2116 => 'School name is not available.',

        // Client Error messages
        2200 => 'Email already exists.',
        2201 => 'Username already exists.',
        2202 => 'School Name already exists.',

        //account status messages
        2230 => 'Account is inactive.',
        2231 => 'Account Locked',
        2232 => 'Account Deleted',

        // login error messages
        2233 => 'Password is invalid.',

        2234 => 'Unauthorized Registration',
        
        //Announcement messages.
        2500 => 'Date range should be between today and future dates.',
        
        2600 => 'Cannot delete subject. Subject has subject areas.'

    ],
];