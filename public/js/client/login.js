$(document).on('submit', '#forgot_password_form, #forgot_success_form', function() {
	$('#proceed_btn').trigger('click');
	return false;
});