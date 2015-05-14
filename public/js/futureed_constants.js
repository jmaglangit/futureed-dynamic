var Constants = {
	
	  FALSE			: 0
	, TRUE			: 1

	, METHOD_POST	: 'POST'
	, METHOD_GET	: 'GET'

	, STATUS_OK		: 200

	, STUDENT		: "Student"
	, CLIENT		: "Client" 
	, PRINCIPAL		: "Principal"
	, PARENT		: "Parent"
	, TEACHER		: "Teacher"

	, AVATAR		: "avatar"
	, REWARDS		: "rewards"
	, PASSWORD		: "password"
	, INDEX			: "index"
	, EDIT			: "edit"

	, USER_PRINCIPAL: "user_principal"
	, USER_PARENT 	: "user_parent"

	, MSG_INTERNAL_ERROR	: "Internal Server Error."
	, MSG_PPW_NOT_MATCH 	: "Picture Password does not match."
	, MSG_PPW_INCORRECT		: "Picture password is incorrect."
	, MSG_PPW_SELECT_NEW 	: "Please select a new picture password."

	// API Message
	, MSG_ACC_CONFIRMED 	: "Your account has already been confirmed."

	, MSG_PW_NOT_MATCH 		: "Password does not match."

	, ATTR_SUBMIT			: "submit"

	, URL_FORGOT_PASSWORD	: function(user_type, email) {
		return '/' + user_type + '/password/forgot?email=' + email;
	}

	, URL_REGISTRATION		: function(user_type, email) {
		return '/' + user_type + '/register/confirm?email=' + email;
	}

	, URL_CHANGE_EMAIL		: function(user_type, email) {
		return '/' + user_type + '/email/confirm?email=' + email;
	}
}