var Constants = {
	
	  FALSE			: 0
	, TRUE			: 1

	, DEFAULT_SIZE	: 10
	, DEFAULT_PAGE	: 1

	, EMPTY_STR		: ''
	, ALL			: 'all'
	, UNDEFINED		: 'undefined'

	, METHOD_POST	: 'POST'
	, METHOD_GET	: 'GET'
	, METHOD_PUT	: 'PUT'
	, METHOD_DELETE	: 'DELETE'

	, STATUS_OK		: 200

	, STUDENT		: "Student"
	, CLIENT		: "Client" 
	, PRINCIPAL		: "Principal"
	, PARENT		: "Parent"
	, TEACHER		: "Teacher"
	, ADMIN			: "Admin"

	, AVATAR		: "avatar"
	, REWARDS		: "rewards"
	, PASSWORD		: "password"
	, INDEX			: "index"
	, EDIT			: "edit"
	, EDIT_EMAIL	: "edit_email"
	, CONFIRM_EMAIL : "confirm_email"

	/**
	* Active Screens
	*/
	, ACTIVE_LIST	: "list"
	, ACTIVE_VIEW	: "view"
	, ACTIVE_EDIT	: "edit"
	, ACTIVE_ADD	: "add"
	, ACTIVE_EMAIL	: "email"

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

	, MSG_INTERNAL_ERROR	: "Hmm, something went wrong. Please contact the system administrator."
	, MSG_PPW_NOT_MATCH 	: "Picture Password does not match."
	, MSG_PPW_INCORRECT		: "Picture password is incorrect."
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

	, UPDATE_PAYMENY_STATUS_SUCCESS 	: "You have successfully updated the payment status."

	, MSG_U_NOTEXIST		: "User does not exist."
	, MSG_U_EXIST 			: "Username already exists."
	, MSG_U_AVAILABLE		: "Username is available."

	, MSG_NO_RECORD			: "No record found."

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