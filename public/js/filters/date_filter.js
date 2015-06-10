angular.module('futureed').filter('ddMMyyyy', function($filter) {
	return function(input) {
		var _date = "NA";
		
		if(angular.isDefined(input)) {
			var datetime_parts = input.split(" ");

			if(angular.isArray(datetime_parts)) {
				var date_parts = datetime_parts[0].split("-");

				if(date_parts[0] == '0000' || date_parts[1] == '00' || date_parts[2] == '00') {
					return _date;
				}

				_date = date_parts[2] + "/" + date_parts[1] + "/" + date_parts[0];
			} 
		}

		return _date;
	};
});