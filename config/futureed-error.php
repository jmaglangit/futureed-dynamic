<?php


return [

	'error_messages' => [
		//Field error codes
		1001 => "Required field not found.",
		1002 => "Required field empty.",


		//Rules messages
		2001 => 'User does not exist.',
		2002 => 'Email does not exist.',
		2003 => 'Account does not exist.',


		//for student error message
		2004 => 'Username and picture password is incorrect.',
		2005 => 'Country does not exist.',
		2006 => 'Confirmation code does not match.',
		2007 => 'Confirmation code has expired.',
		2008 => 'The Username or Email you entered is invalid. Please try inputting again. If the account you are attempting to login is for a student less than 14 yrs old, please login via the parent site.',
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
		2028 => 'The Student has to be 14 years old or above to be able to register.',
		2029 => 'Access authentication failure.',
		2030 => 'Access authorization is required.',
		2031 => 'Access authorization is invalid.',
		2032 => 'Unauthorized access.',
		2033 => 'Username/Email or password is invalid',
		2034 => 'Username/Email or password is invalid. Have you verified your email? Please check your inbox. Your account may have been locked, please click on forgot password to reset your password.',
		2035 => 'Account has been locked. Please click on forgot password to reset your password.',
		2036 => 'Client has active transaction.',
		2037 => 'Student has an existing subscription.',
		2038 => 'No student added.',
		2039 => 'Student is not associated to the parent.',
		2040 => 'Student already exist.',
		2041 => 'Country is required',
        2042 => 'Student has already rated this help request answer.',
        2043 => 'Student cannot rate his/her own help request answer.',
		2044 => 'The Postal Code format is invalid.',
		2045 => 'The Postal Code may not be greater than 10 characters.',
		2046 => 'The contact number should not exceed 20 digits.',
		2047 => 'Country name is required.',
		2048 => 'Grade name is required.',
		2049 => 'Account has already been registered.',
		2050 => 'Student has an active subscription.',
		2051 => 'Class has already ended.',
		2052 => 'No Image',
		2053 => 'File Location is invalid.',
		2054 => 'File deleted.',
		2055 => 'Practice Exercise has already been Completed.',


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
		2112 => 'Password must be at least 8 characters and with at least 1 number.',
		2113 => 'Username and password is invalid.',
		2114 => 'Your password is incorrect.',
		2115 => 'Contact number format is incorrect.',
		2116 => 'School name is not available.',
		2117 => 'The Student has to be 14 years old or above.',
		2118 => 'Your account is being reviewed or contact administrator for assistance.',
		2119 => 'This record is being used.',
		2120 => 'This record is invalid.',
		2121 => 'Unable to Delete. Principal is associated to a school.',
		2122 => 'Unable to Delete. Teacher is associate to a class.',
		2123 => 'Unable to Delete. Parent is associated to a student.',
		2124 => 'Student does not exist.',
		2125 => 'Student is already in a class.',
		2126 => 'Unable to Delete. Student is associated to a Parent.',
		2127 => 'Unable to Delete. Student has Points.',
		2128 => 'Unable to Delete. Student has Badge.',
		2129 => 'Unable to Delete. Student has Class.',
		2130 => 'Parent does not have Student.',
		2131 => 'Student is already added.',
		2132 => 'Invitation code is invalid.',
		2133 => 'Registration token is invalid.',
		2134 => "Can't change School: Student has active Subscription.",
		2135 => "The class is already full.",
		2136 => 'Unable to Delete.Tip has rating.',
		2137 => 'Unable to delete. Help request has answers.',
		2138 => 'Password image is required.',
		2139 => 'Points to unlock must be lesser than Points to finish.',
		2140 => 'Unable to Delete. Module has contents.',
		2141 => 'Unable to Delete. Module has questions.',
		2142 => 'The image must be a file of type: jpeg, jpg, png.',
		2143 => 'The image size had exceeded 2MB.',
		2144 => 'Module does not exist',
		2145 => 'Student needs to watch the videos again.',
		2146 => 'Prevent having dot for an image file name.',

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

		2600 => 'Cannot delete subject. Subject has subject areas.',
		2601 => 'Cannot delete admin.',
		2602 => 'The school is invalid.',

		// Custom country messages.
		2603 => 'The country field is required.',
		2604 => 'The country is invalid'

	],
];