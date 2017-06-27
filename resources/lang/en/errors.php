<?php

use FutureEd\Services\ErrorMessageServices as Error;

return [

		//Field error codes
		1001 => 'Required field not found.',
		1002 => 'Required field empty.',
		1003 => 'The :attribute is required.',
		1004 => 'The :attribute is invalid.',
		1005 => 'Points to :attribute must be a number.',
		1006 => 'The :attribute text is required.',
		1007 => 'The :attribute already exists.',
		1008 => 'The :attribute format is invalid.',
		1009 => 'The :attribute may not be greater than 10 characters.',
		1010 => 'The :attribute format is incorrect.',
		1011 => 'The :attribute should not exceed 20 digits.',
		1012 => 'The :attribute name is required.',
		1013 => 'The :attribute must be a number',
		1014 => 'The :attribute does not exist.',
		1015 => 'Total :attribute is required',
		1016 => 'Total :attribute must be a number',
		1017 => 'The :attribute field is required.',
		1018 => 'The :attribute field is invalid.',

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
		2019 => 'Your Account has been locked.',
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
		2042 => 'Student has already rated this help request answer.',
		2043 => 'Student cannot rate his/her own help request answer.',
		2044 => 'The Postal Code format is invalid.',
		2045 => 'The Postal Code may not be greater than 10 characters.',
		2046 => 'The contact number should not exceed 20 digits.',
		2049 => 'Account has already been registered.',
		2050 => 'Student has an active subscription.',
		2051 => 'Class has already ended.',
		2052 => 'No Image',
		2053 => 'File Location is invalid.',
		2054 => 'File deleted.',
		2055 => 'Practice Exercise has already been Completed.',
		2056 => 'You need to review the teaching content.',
		2057 => 'Unable to Delete record.',
		2058 => 'Module is incomplete. Please contact administrator.',
		2059 => 'File does not exist.',
		2060 => 'Student is currently logged-in on another device.',
		2061 => 'Client is currently logged-in on another device.',
		2062 => 'Admin is currently logged-in on another device.',
		2063 => 'User is currently logged-in on another device.',
		2064 => 'Invalid export file format',
		2065 =>	'File does not exist.',
		2066 => 'You already have this accessory',
		2067 => 'No Accessories available',
		2068 => 'This accessory is not available for your avatar',
		2069 => 'You do not have enough points to buy this accessory',
		2070 => 'Invalid graph answer.',
		2071 => 'Module is not available',
		Error::REMOVE_STUDENT_BEFORE_DATE => 'Student cannot be deleted if date removed is less than date added',
		Error::NOT_ENOUGH_POINTS_ON_GAME => 'You do not have enough points to buy this game',
		Error::MODULE_TRANSLATION_LOCALE => 'Need to initialize new language.',
		Error::MODULE_TRANSLATION_UPDATE_FAIL => 'Failed translation update.',

		2072 => 'Picture password is incorrect. You have :remaining_attempts remaining attempt(s).',
		2073 => 'Please click forgot password to reset your password.',
		2074 => 'Unable to add Student. Country curriculum is not the same.',
		2075 => 'Username/Email or password is invalid. You have :remaining_attempts remaining attempt(s).',


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
		2147 => 'Unable to Delete. Subscription already expired.',
		2148 => 'Unable to generate report.',
		2149 => 'The file must be a file of type: csv.',
		2150 => 'This tip has an existing rating.',
		2151 => 'This help answer has an existing rating.',
		2152 => 'The new email and the current email are the same.',
		2153 => 'Grade',
		2154 => 'Country',
		2155 => 'Subject',
		2156 => 'Area',
		2157 => 'School',
		2158 => 'unlock',
		2159 => 'finish',
		2160 => 'module',
		2161 => 'Module',
		2162 => 'Question',
		2163 => 'Code',
		2164 => 'Points Equivalent',
		2165 => 'answer text',
		2166 => 'image',
		2167 => 'empty',
		2168 => 'Difficulty',
		2169 => 'Points earned',
		2170 => 'Sequence number',
		2171 => 'Answer',
		2172 => 'Description',
		2173 => 'Question order',
		2174 => 'Student ID',
		2175 => 'Teacher',
		2176 => 'Client',
		2177 => 'Number of seats',
		2178 => 'Seats taken',
		2179 => 'Class name',
		2180 => 'Class name should be a minimum of 2 characters.',
		2181 => 'Class name may not be greater than 128 characters.',
		2182 => 'Class',
		2183 => 'Date range should be today or after the student was added.',
		2184 => 'Client Name',
		2185 => 'Name',
		2186 => 'Selected country',
		2187 => 'Postal Code',
		2188 => 'Contact number',
		2189 => 'Password image',
		2190 => 'Grade Code',
		2191 => 'Group',
		2192 => 'Student',
		2193 => 'Help request',
		2194 => 'Rating',
		2195 => 'User',
		2196 => 'Subject Area',
		2197 => 'Link',
		2198 => 'Invoice',
		2199 => 'Subscription',
		2200 => 'Email already exists.',
		2201 => 'Username already exists.',
		2202 => 'School Name already exists.',
		2203 => 'Discount',
		2204 => 'Test',
		2205 => 'Section',
		2206 => 'Selected Answer',
		2207 => 'Age',
		2208 => 'Parent',
		2209 => 'Order',
		2210 => 'Badge name',
		2211 => 'Content',
		2212 => 'Event',
		2213 => 'Points',
		2214 => 'Tip',
		2215 => 'Area Code',
		2216 => 'Subject Code',
		2217 => 'Learning Style',
		2218 => 'Media',
		2219 => 'Image',
		2220 => 'Content URL',
		2221 => 'Teaching Module',
		2222 => 'Minimum Seats already exists.',
		2223 => 'Title',
		2224 => 'Birth date',

		//already exist subscription messages
		2225 => 'Sorry, you already have an existing subscription.',
		2226 => 'Sorry, student/s may already have an existing subscription.',

		2227 => 'dynamic',
		2228 => 'has difficulty',

		//  Parent Client Error Messages
		Error::BILLING_INFO_MISSING => 'You need to update your contact information in order to proceed buy a subscription.',

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
		2604 => 'The country is invalid',

		7000 => 'Hmm, something went wrong. Please contact the system administrator.',

		//  For subscription request error messages
		Error::SUBSCRIPTION_MUST_BE_A_NUMBER => 'The :attribute must be a number',
		Error::SUBSCRIPTION_NAME_REQUIRED => 'The subscription name field is required',
		Error::SUBSCRIPTION_NAME_INVALID => 'The subscription name format is invalid',
		Error::SUBSCRIPTION_LSP_REQUIRED => 'The learning style is required',
		Error::SUBSCRIPTION_LSP_INVALID => 'The learning style format is invalid',

		//  For trial module error messages
		Error::TRIAL_MODULE_ANSWER_IS_REQUIRED => 'Answer is required',
		Error::TRIAL_MODULE_MULTIPLE_ANSWERS_REQUIRED => 'Answers are required',
		Error::TRIAL_MODULE_QUAD_PLOTTING_REQUIRED => 'Plot a point to answer',
		Error::TRIAL_MODULE_DRAG_DROP_REQUIRED => 'Drag at least one object to answer',

		// localization
		Error::LANGUAGE_NOT_AVAILABLE => 'Language code does not match.',
		Error::LANGUAGE_FIELD_NOT_AVAILABLE => 'Field not available for translation.',

		Error::STUDENT_DIFF_CURRICULUM => 'Cannot add student because it has a different curriculum.',
		Error::STUDENT_BIRTHDATE_INVALID_FORMAT => 'The birth date is not completely filled out.',

		// game time
		Error::GAME_TIME_CANNOT_PLAY => 'Please complete a module to unlock playtime!',

];