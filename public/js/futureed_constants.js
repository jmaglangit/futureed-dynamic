var Constants = {
	
	  FALSE			: 0
	, TRUE			: 1
	, NEGATIVE_1         : -1

	, DEFAULT_SIZE	: 10
	, DEFAULT_PAGE	: 1

	, CUSTOM_TABLE_SIZE : 5
	, CUSTOM_LIST_SIZE	: 9

	, EMPTY_STR		: ''
	, ALL			: 'all'
	, UNDEFINED		: 'undefined'
	, NULL 			: null
	, INVITE        : 'invite'

	, METHOD_POST	: 'POST'
	, METHOD_GET	: 'GET'
	, METHOD_PUT	: 'PUT'
	, METHOD_DELETE	: 'DELETE'
	, METHOD_PATCH	: 'PATCH'

	, STATUS_OK		: 200

	, STUDENT		: "Student"
	, CLIENT		: "Client" 
	, PRINCIPAL		: "Principal"
	, PARENT		: "Parent"
	, TEACHER		: "Teacher"
	, ADMIN			: "Admin"
	, SUPER_ADMIN	: "Super Admin"
	, PEACHES		: "Peaches"

	, PENDING		: "Pending"
	, PAID			: "Paid"
	, OPEN			: "Open"
	, ANSWERED		: "Answered"
	, CANCELLED		: "Cancelled"
	, ACCEPTED		: "Accepted"
	, REJECTED		: "Rejected"

	, AVATAR		: "avatar"
	, REWARDS		: "rewards"
	, PASSWORD		: "password"
	, INDEX			: "index"
	, EDIT			: "edit"
	, EDIT_EMAIL	: "edit_email"
	, CONFIRM_EMAIL : "confirm_email"
	, AVATAR_ACCESSORY	:"avatar_accessory"
	, SETTINGS		: 'settings'
	, GAMES			: 'games'
	, PLAY_GAME		: 'play game'

	, AGEGROUP		: "agegroup"
	, CONTENTS 		: "contents"
	, QANDA 		: "qanda"

	, MODULE		: "Module"
	, GENERAL		: "General"
	, CONTENT 		: "Content"
	, QUESTION		: "Question"
	, ANSWER		: "Answer"
	, DASHBOARD		: "Dashboard"
	, WRONG			: "Wrong"
	, CORRECT		: "Correct"
	, FAILED		: "Failed"
	, RETAKE		: "Retake"

	, HIDE_MODULE	: "Hide Module"

	, TRIAL_QUESTIONS	:10
	, ERROR_MSG	: 2
	, MAX_CODING_SIZE	: 1920
	, REQ_CURR_FIELDS	: "These fields are required"
	, UNDEFINE		: undefined

	/**
	 * Subscription filters
	 */
	, SUBSCRIPTION_COUNTRY	:	"country"
	, SUBSCRIPTION_SUBJECT	: 	"subject"
	, SUBSCRIPTION_PLAN		:	"plan"
	, SUBSCRIPTION_DAYS		:	"Days"
	, SUBSCRIPTION_OTHERS	: 	"others"
	, SUBSCRIPTION_STUDENTS	:	"students"
	, SUBSCRIPTION_CLASSROOM:	"classrooms"
	, SUBSCRIPTION_PACKAGES	: 	"Packages"
	, SUBSCRIPTION			:	"subscription"

	/**
	 * Admin Subscription
	 */
	, BULK_SETTINGS : 'bulk_settings'
	, CLIENT_DISCOUNT : 'client_discount'
	/**
	* Media Types
	*/
	, VIDEO			: 1
	, TEXT			: 2
	, IMAGE			: 3

	, NONE 			: "None"

	/**
	* Help Tabs
	*/
	, CURRENT 		: "current"
	, OWN 			: "own"
	, CLASSMATE 	: "classmate"

	/**
	* Active Screens
	*/
	, ACTIVE_LIST	: "list"
	, ACTIVE_VIEW	: "view"
	, ACTIVE_EDIT	: "edit"
	, ACTIVE_ADD	: "add"
	, ACTIVE_EMAIL	: "email"
	, ACTIVE_IMPORT	: "import"
	, ACTIVE_CANCEL	: "cancel"

	, ACTIVE_QUESTIONS 	: "questions"
	, ACTIVE_CONTENTS 	: "contents"
	, ACTIVE_SCHOOL		: "school"
	, ACTIVE_SCHOOL_TEACHER	: "school_teacher"
	, ACTIVE_SCHOOL_TEACHER_PROGRESS : "school_teacher_progress"
    , ACTIVE_SCHOOL_TEACHER_SCORES : "school_teacher_scores"
    , ACTIVE_SCHOOL_STUDENT_PROGRESS : "school_student_progress"
    , ACTIVE_SCHOOL_STUDENT_SCORES : "school_student_scores"
	, ACTIVE_QUESTIONS_PREVIEW : "questions_preview"

	, ADD_CLIENT 	: "add_client"
	, ADD_STUDENT	: "add_student"
	, ANNOUNCEMENT 	: "announcement"
	, PRICE 		: "price"
	, LOCALIZATION	: "localization"

	, DELETE_ERROR 		: "Error deleting."
	, DELETE_SUCCESS	: "successfully deleted."
	, EDIT_SUCCESS 		: "successfully edited."
	, ADD_SUCCESS_MSG 	: "successfully added."

	, STATUS_TRUE 	: "true"
	, STATUS_FALSE 	: "false"

	, M_CHOICE		: "MC"

	, BACK 			: "Back"
	, NEXT 			: "Next"

	, YES 			: "Yes"
	, NO 			: "No"

	, FILLINBLANK 		: "FIB"
	, MULTIPLECHOICE 	: "MC"
	, ORDERING 			: "O"
	, PROVIDE 			: "N"
	, GRAPH				: "GR"
	, QUADRANT			: "QUAD"
	, CODING			: "COD"

	, HORIZONTAL		: "horizontal"
	, VERTICAL			: "vertical"

	, MSG_INTERNAL_ERROR	: "Hmm, something went wrong. Please contact the system administrator."
	, MSG_PPW_NOT_MATCH 	: "Picture Password does not match."
	, MSG_PPW_INCORRECT		: "Picture password is incorrect."
	, MSG_PPW_SELECT 		: "Please select a picture password."
	, MSG_PPW_SELECT_NEW 	: "Please select a new picture password."

	// API Message
	, MSG_ACC_CONFIRMED 	: "Your account has already been confirmed."

	, MSG_PW_NOT_MATCH 		: "Password does not match."

	, ATTR_SUBMIT			: "submit"

	, MSG_EA_NOTEXIST		: "Email does not exist."
	, MSG_EA_CONFIRM		: "Confirm your new email address."
	, MSG_EA_EXIST 			: "Email address already exists."
	, MSG_EA_AVAILABLE 		: "Email address is available."
	, MSG_EA_CURR_NOTMATCH	: "Current email address does not match."
	, MSG_EA_NOT_MATCH		: "Email Address does not match."
	, ANNOUNCE_SUCCESS		: "Success You've created Site Maintainance Announcement."

	, ADD_PRICE_SUCCESS 		: "You have successfully created a subscription."
	, EDIT_PRICE_SUCCESS 		: "You have successfully updated this subscription."
	, DELETE_PRICE_SUCCESS 		: "You have successfully deleted this subscription."

	, ADD_BULK_SUCCESS 			: "You have successfully created a bulk."
	, EDIT_BULK_SUCCESS 		: "You have successfully updated this bulk."
	, DELETE_BULK_SUCCESS 		: "You have successfully deleted this bulk."

	, ADD_DISCOUNT_SUCCESS 			: "You have successfully created a client discount."
	, EDIT_DISCOUNT_SUCCESS 		: "You have successfully updated a client discount."
	, DELETE_DISCOUNT_SUCCESS 		: "You have successfully deleted a client discount."

	, ADD_AREA_SUCCESS 			: "You have successfully added a new subject area."
	, EDIT_AREA_SUCCESS 		: "You have successfully updated a subject area."
	, DELETE_AREA_SUCCESS 		: "You have successfully deleted a subject area."

	, UPDATE_PAYMENT_STATUS_SUCCESS 	: "You have successfully updated the payment status."
	, DELETE_INVOICE_SUCCESS 	: "You have successfully deleted the selected invoice."
	, ADD_STUDENT_SUCCESS 		: "You have successfully added the selected student."
	, REMOVE_STUDENT_SUCCESS 	: "You have successfully removed the selected student."
	, STUDENT_NOT_ALLOWED	:	"Cannot add student because student_name has a different curriculum."

	, RESET_SUCCESS 		: "Your module was reset successfully."

	, MSG_U_NOTEXIST		: "User does not exist."
	, MSG_U_EXIST 			: "Username already exists."
	, MSG_U_AVAILABLE		: "Username is available."

	, MSG_NO_RECORD			: "No record found."

	, MSG_FILL_FIELDS 		: "Please fill the required fields."

	, POINT_UPDATE 			: "successfully updated the point"
	, BADGE_UPDATE 			: "successfully updated the badge"
	, BADGE_DELETE 			: "successfully deleted the badge"

	, ACCEPT_TERMS			: "Please accept the terms and conditions."

	, ATTR_CURRENT_EMAIL 	: "current_email"
	, ATTR_NEW_EMAIL 		: "new_email"
	, ATTR_CONFIRM_EMAIL 	: "confirm_email"
	, ATTR_PASSWORD 		: "password"

	, LSP_URL 				: "/student/dashboard/follow-up-registration"

	, DELETE_STU_SUCCESS 	: "Student successfully deleted"

	/*Billing Information for invoice*/

	, BILL_COMPANY				: "Futureed Pte. Ltd."
	, BILL_STREET				: "20 Maxwell Road #09-17"
	, BILL_ADDRESS				: "Maxwell House"
	, BILL_COUNTRY				: "Singapore 069113"
	, BILL_EMAIL				: "i n f o @ f u t u r e l e s s o n . c o m"
	, CC_NAME					: "Futureed Pte Ltd"
	, BANK_NAME					: "OCBC"
	, BANK_ACCT_NO_SGD			: "582-066825 -001 SGD"
	, BANK_ACCT_NO_USD			: "508-011715-301 USD"
	, BANK_ADDRESS				: "65 Chulia Street, #01-00, OCBC Centre, Singapore 049513"
	, BANK_CODE					: "7339"
	, BRANCH_CODE				: "582 (SGD), 508 (USD)"
	, SGD_BRANCH_CODE			: "582"
	, SGD_ACCT_NO				: "066825001"
	, USD_BRANCH_CODE			: "508"
	, USD_ACCT_NO				: "011715-301"
	, SWIFT_CODE				: "OCBCSGSG"

	// attributes
	, STATIC					: "static"
	, DATE						: "date"
	, DATE_YYYYMMDD				: "yyyyMMdd"

	, ENABLED					: "Enabled"
	, DISABLED					: "Disabled"

	// To avoid scenario of invalid gender, API rejects 'male' or 'female'
	, MALE						: "Male"
	, FEMALE					: "Female"

	, VOLUME					: "Volume"

	/*Birthdate dropdown config*/

	, MIN_AGE					: 6
	, MAX_AGE					: 99
	, AGE_RANGE					: 14

	, FACEBOOK 					: "Facebook"
	, GOOGLE 					: "Google"

	, PASSWORD_TIP				: "Password must be at least 8 characters and with at least 1 number."

	, SECURITY					: "Security"
	, ADMINISTRATOR				: "Administrator"
	, USERS						: "Users"
	, ERRORS					: "Errors"
	, SYSTEM					: "System"

	, REPORT_CARD				: "Report Card"
	, SUMMARY_PROGRESS			: "Summary Progress"
	, CURRENT_LEARNING			: "Current Learning"
	, SUBJECT_AREA				: "Subject Area"
	, SUBJECT_AREA_HEATMAP		: "Subject Area Heatmap"
	, QUESTION_ANALYSIS			: "Question Analysis"

	,GRAPH_MONTHLY				: "Hours on Platform"
	,GRAPH_WEEKLY				: "Hours spent in last seven days"
	,GRAPH_SUBJECT_AREA			: "Progress Made - % Completed"
	,GRAPH_SUBJECT_AREA_HEATMAP	: "Heatmap - % Completed"

	, HTTP_UNAUTHORIZED			: 401
	, HTTP_NOT_ACCEPTABLE 		: 406

	/*Country Codes*/
	, UNITED_STATES				: 840

	/* Localization */
	, LOCALIZATION_SETTING		: 'localization settings'
	, LOCALIZATION_TRANSLATION	: 'localization translation'
	, LOCALIZATION_MODULE		: 'localization module'
	, LOCALIZATION_QUESTION		: 'localization question'
	, LOCALIZATION_QUESTION_ANS	: 'localization question answer'
	, LOCALIZATION_ANSWER_EXP	: 'localization answer explanation'
	, LOCALIZATION_QUOTE		: 'localization quote'

	, REPORT_PROGRESS_PASS	: 81
	, REPORT_PROGRESS_MEDIAN_CEILING	: 80
	, REPORT_PROGRESS_MEDIAN_FLOOR	: 51
	, REPORT_PROGRESS_FAIL	: 50

	, COMPLETED 				: 'Completed'
	, ON_GOING 					: 'On Going'

	/* question dynamic template */
	, NUMBER					: 'NUMBER'
	, OBJECT					: 'OBJECT'
	, NAME						: 'NAME'
	, ALPHA						: 'ALPHA'
	, ADDITION					: 'addition'
	, SUBTRACTION				: 'subtraction'
	, DIVISION					: 'division'
	, MULTIPLICATION			: 'multiplication'
	, FRACTION_ADDITION			: 'fraction_addition'
	, FRACTION_SUBTRACTION		: 'fraction_subtraction'
	, FRACTION_MULTIPLICATION	: 'fraction_multiplication'
	, FRACTION_DIVISION			: 'fraction_division'
	, FRACTION_ADDITION_BUTTERFLY		: 'fraction_addition_butterfly'
	, FRACTION_SUBTRACTION_BUTTERFLY	: 'fraction_subtraction_butterfly'
	, FRACTION_ADDITION_WHOLE			: 'fraction_addition_whole'
	, FRACTION_SUBTRACTION_WHOLE		: 'fraction_subtraction_whole'
	, INTEGER_ADDITION					: 'integer_addition'
	, INTEGER_SORT_SMALL				: 'integer_sort_small'
	, INTEGER_SORT_LARGE				: 'integer_sort_large'
	, INTEGER_CONVERT_NUMBER	: 'integer_convert_number'
	, INTEGER_DECIMAL			: 'integer_decimal'
	, INTEGER_EXPANDED_DECIMAL	: 'integer_expanded_decimal'
	, INTEGER_EXTENDED			: 'integer_extended'
	, INTEGER_COUNTING			: 'integer_counting'
	, INTEGER_IDENTIFY			: 'integer_identify'
	, INTEGER_ROUNDING_NUMBER	: 'integer_rounding_number'
	, INTEGER_REGROUP			: 'integer_regroup'
	, INTEGER_RANDOM_WORD		: 'integer_random_word'
	, INTEGER_RANDOM_NUMBER		: 'integer_random_number'
	, DECIMAL_COMPARE			: 'decimal_compare'
	, DECIMAL_ADDITION			: 'decimal_addition'
	, DECIMAL_NUMERIC			: 'decimal_numeric'
	, DECIMAL_UNDERSTAND		: 'decimal_understand'

	/* question dynamic template variables */
	, NUMBER1					: 'number1'
	, NUMBER2					: 'number2'
	, ADDENDS1					: 'addends1'
	, ADDENDS2					: 'addends2'
	, MINUEND					: 'minuend'
	, SUBTRAHEND				: 'subtrahend'
	, MULTIPLICAND				: 'multiplicand'
	, MULTIPLIER				: 'multiplier'
	, DIVIDEND					: 'dividend'
	, DIVISOR					: 'divisor'
	, NUMERATOR_WHOLE			: 'numerator_whole'
	, NUMERATOR1				: 'numerator1'
    , NUMERATOR2				: 'numerator2'
    , DENOMINATOR_WHOLE			: 'denominator_whole'
	, DENOMINATOR1				: 'denominator1'
    , DENOMINATOR2				: 'denominator2'
	, DECIMAL_ADDENDS1			: 'decimal_addends1'
	, DECIMAL_ADDENDS2			: 'decimal_addends2'
	, INTEGER_RANDOM_DIGIT		: 'integer_random_digit'
	, DECIMAL_RANDOM_NUMBER1	: 'decimal_random_number1'
	, DECIMAL_RANDOM_NUMBER2	: 'decimal_random_number2'
	, DECIMAL_RANDOM_WORD		: 'decimal_random_word'
	, DECIMAL_RANDOM_DIGIT		: 'decimal_random_digit'
	, DECIMAL_RANDOM_NUMBER		: 'decimal_random_number'

	/* steps label dynamic template*/
	, STEPS_LABEL				: ['ones', 'tens', 'hundreds', 'thousands', 'one thousands', 'ten thousands', 'hundred thousands']
	, NTH_INDEX					: 'nth'

	, MSG_CREATED				: function(noun) {
		return noun + " created.";
	}

	, MSG_UPDATED				: function(noun) {
		return noun + " updated.";
	}

	, MSG_DELETED				: function(noun) {
		return noun + " deleted.";
	}

	, MSG_ACCEPTED				: function(noun) {
		return noun + " accepted.";
	}

	, MSG_REJECTED				: function(noun) {
		return noun + " rejected.";
	}

	, URL_FORGOT_PASSWORD		: function(user_type) {
		return '/' + user_type + '/password/forgot';
	}

	, URL_REGISTRATION			: function(user_type) {
		return '/' + user_type + '/register/confirm';
	}

	, URL_CHANGE_EMAIL			: function(user_type) {
		return '/' + user_type + '/email/confirm';
	}

	, URL_USER_CREATION			: function(user_type) {
		return '/' + user_type + '/user/confirm';
	}
}