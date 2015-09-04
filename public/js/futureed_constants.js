var Constants = {
	
	  FALSE			: 0
	, TRUE			: 1

	, DEFAULT_SIZE	: 10
	, DEFAULT_PAGE	: 1

	, CUSTOM_TABLE_SIZE : 5

	, EMPTY_STR		: ''
	, ALL			: 'all'
	, UNDEFINED		: 'undefined'
	, NULL 			: null

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

	, AGEGROUP		: "agegroup"
	, CONTENTS 		: "contents"
	, QANDA 		: "qanda"

	, MODULE		: "Module"
	, GENERAL		: "General"
	, CONTENT 		: "Content"
	, QUESTION		: "Question"
	, ANSWER		: "Answer"

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
	, ALL 			: "all"
	, CLASSMATE 	: "classmate"

	/**
	* Active Screens
	*/
	, ACTIVE_LIST	: "list"
	, ACTIVE_VIEW	: "view"
	, ACTIVE_EDIT	: "edit"
	, ACTIVE_ADD	: "add"
	, ACTIVE_EMAIL	: "email"

	, ACTIVE_QUESTIONS 	: "questions"
	, ACTIVE_CONTENTS 	: "contents"

	, ADD_CLIENT 	: "add_client"
	, ADD_STUDENT	: "add_student"
	, ANNOUNCEMENT 	: "announcement"
	, PRICE 		: "price"

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

	, ADD_DISCOUNT_SUCCESS 			: "You have successfully create a client discount."
	, EDIT_DISCOUNT_SUCCESS 		: "You have successfully updated a client discount."
	, DELETE_DISCOUNT_SUCCESS 		: "You have successfully deleted a client discount."

	, ADD_AREA_SUCCESS 			: "You have successfully added a new subject area."
	, EDIT_AREA_SUCCESS 		: "You have successfully updated a subject area."
	, DELETE_AREA_SUCCESS 		: "You have successfully deleted a subject area."

	, UPDATE_PAYMENT_STATUS_SUCCESS 	: "You have successfully updated the payment status."
	, DELETE_INVOICE_SUCCESS : "You have successfully deleted the selected invoice."

	, RESET_SUCCESS 		: "Your module was reset successfully."

	, MSG_U_NOTEXIST		: "User does not exist."
	, MSG_U_EXIST 			: "Username already exists."
	, MSG_U_AVAILABLE		: "Username is available."

	, MSG_NO_RECORD			: "No record found."

	, MSG_FILL_FIELDS 		: "Please fill the required fields."

	, POINT_UPDATE 			: "successfully updated the point"
	, BADGE_UPDATE 			: "successfully updated the badge"
	, BADGE_DELETE 			: "successfully deleted the badge"

	, ATTR_CURRENT_EMAIL 	: "current_email"
	, ATTR_NEW_EMAIL 		: "new_email"
	, ATTR_CONFIRM_EMAIL 	: "confirm_email"
	, ATTR_PASSWORD 		: "password"

	, LSP_URL 				: "/student/dashboard/follow-up-registration"

	/*Billing Information for invoice*/

	, BILL_COMPANY				: "Futureed Pte. Ltd."
	, BILL_STREET				: "545 Orchard Road, #03-24"
	, BILL_ADDRESS				: "Far East Shopping Centre"
	, BILL_COUNTRY				: "Singapore 238882"
	, CC_NAME 					: "Futureed Pte Ltd"
	, BANK_NAME					: "OCBC"
	, BANK_ACCT_NO_SGD 			: "582-066825 -001 SGD"
	, BANK_ACCT_NO_USD 			: "508-011715-301 USD"
	, BANK_ADDRESS 				: "65 Chulia Street, #01-00, OCBC Centre, Singapore 049513"
	, BANK_CODE 				: "7339"
	, BRANCH_CODE 				: "582 (SGD), 508 (USD)"
	, SWIFT_CODE 				: "OCBCSGSG"

	/*Birthdate dropdown config*/

	, MIN_AGE 			: 12
	, MAX_AGE			: 99
	, AGE_RANGE			: 14

	, URL_FORGOT_PASSWORD	: function(user_type) {
		return '/' + user_type + '/password/forgot';
	}

	, URL_REGISTRATION		: function(user_type) {
		return '/' + user_type + '/register/confirm';
	}

	, URL_CHANGE_EMAIL		: function(user_type) {
		return '/' + user_type + '/email/confirm';
	}

	, URL_USER_CREATION		: function(user_type) {
		return '/' + user_type + '/user/confirm';
	}
}