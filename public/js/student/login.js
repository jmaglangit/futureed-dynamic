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

$("#birth_date").change(function(){
    var bdate = $("#birth_date").val();
    if(bdate) {
        var str=bdate.split('-');
        var firstdate = new Date(str[0],str[1],str[2]);
        var today = new Date();
        var dayDiff = Math.ceil(today.getTime() - firstdate.getTime()) / (1000 * 60 * 60 * 24 * 365);
        var age = parseInt(dayDiff);

        if(age < Constants.AGE_RANGE) {
            $("#invalid_student").modal({
                backdrop: 'static',
                keyboard: false,
                show    : true
            });
        }
    }
});


