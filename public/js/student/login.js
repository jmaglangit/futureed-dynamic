//login
$(document).on('submit', '#login_form', function() {
	$("#validate_user_btn").trigger('click');
	return false;
});

$(document).on('submit', '#forgot_password_form', function() {
	$("#forgot_password_btn").trigger('click');
	return false;
});

$(document).on('submit', '#forgot_success_form', function() {
	$("#validate_code_btn").trigger('click');
	return false;
});

$(document).on('submit', '#registration_success_form', function() {
	$("#confirm_registration_btn").trigger('click');
	return false;
});

