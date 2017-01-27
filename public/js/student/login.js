function checkAge() {
        if($("#birth_date").val() && moment().diff($("#birth_date").val(), 'years',false) < Constants.AGE_RANGE) {
            $("#invalid_student").modal({
                backdrop: 'static',
                keyboard: false,
                show    : true
            });
        }
}


