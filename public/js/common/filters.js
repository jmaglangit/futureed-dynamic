/**
* Author: Mar
*
* Formats date object to dd/MM/yy (e.g 01/02/15 which is February 1, 2015)
* 
* Parameters
*	input 	- can be date object, milliseconds, "0000-00-00 00:00:00" date string format
* Returns
*	_date 	- "dd/MM/yy" date string format
*/
angular.module('futureed').filter('ddMMyy', function($filter) {
	return function(input, default_msg) {
		var _date = (default_msg) ? default_msg : Constants.EMPTY_STR;
		
		if(!input) {
			return _date;
		}
		
		// Replace spaces since FF does not have a date parse
		if(typeof input !== "object") {
			input = input.replace(/(.+) (.+)/, "$1T$2Z");
		}

		_date = new Date(input);
		if(_date != "Invalid Date") {
			_date = $filter('date')(_date.getTime(), 'dd/MM/yy');
		} else {
			_date = (default_msg) ? default_msg : Constants.EMPTY_STR;
		}

		return _date;
	};
});

/**
* Author: Mar
*
* Formats date object to dd/MM/yy HH:mm:ss (e.g 01/02/15 11:11:11 which is February 1, 2015 11:11:11)
* 
* Parameters
*	input 	- can be date object, milliseconds, "0000-00-00 00:00:00" date string format
* Returns
*	_date 	- "dd/MM/yy HH:mm:ss" date string format
*/
angular.module('futureed').filter('ddMMyyHHmmss', function($filter) {
	return function(input, default_msg) {
		var _date = (default_msg) ? default_msg : Constants.EMPTY_STR;
		
		if(!input) {
			return _date;
		}
		
		// Replace spaces since FF does not have a date parse
		if(typeof input !== "object") {
			input = input.replace(/(.+) (.+)/, "$1T$2Z");
		}
		
		_date = new Date(input);
		if(_date != "Invalid Date") {
			var date_part = input.split(/[^0-9]/);
				// FF and Chrome returns different date value
				_date = new Date( date_part[0], date_part[1]-1, date_part[2], date_part[3], date_part[4], date_part[5] );
				_date = $filter('date')(_date.getTime(), 'dd/MM/yy HH:mm:ss');
		} else {
			_date = (default_msg) ? default_msg : Constants.EMPTY_STR;
		}

		return _date;
	};
});

/**
* Author: Mar
*
* Appends "%" to an input
*/
angular.module('futureed').filter('percent', function($filter) {
	return function(input) {
		var percent = input + " %";

		return percent;
	};
});

angular.module('futureed').filter('trustAsResourceUrl', ['$sce', function($sce) {
    return function(val) {
        return $sce.trustAsResourceUrl(val);
    };
}]);

angular.module('futureed').filter('trustAsHtml', ['$sce', function($sce) {
    return function(val) {
        return $sce.trustAsHtml(val);
    };
}]);