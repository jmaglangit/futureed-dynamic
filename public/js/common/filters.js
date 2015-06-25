angular.module('futureed').filter('ddMMyy', function($filter) {
	return function(input) {
		var _date = new Date(input);

		if(_date != "Invalid Date") {
			_date = $filter('date')(_date, 'dd/MM/yy');
		} else {
			_date = Constants.EMPTY_STR;
		}

		return _date;
	};
});

angular.module('futureed').filter('percent', function($filter) {
	return function(input) {
		var percent = input + " %";

		return percent;
	};
});