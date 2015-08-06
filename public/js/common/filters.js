/**
* Author: Mar
*
* Formats date object tp dd/MM/yy (e.g 01/02/15 which is February 1, 2015)
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