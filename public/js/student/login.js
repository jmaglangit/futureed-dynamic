function checkAge() {
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
}


