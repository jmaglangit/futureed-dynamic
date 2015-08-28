$(document).ready(function() {
	$("#birth_date").dateDropdowns({
	    submitFieldName: 'birth_date',
	    minAge: Constants.MIN_AGE,
	    maxAge: Constants.MAX_AGE
	});
});

