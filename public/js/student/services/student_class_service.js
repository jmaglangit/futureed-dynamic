angular.module('futureed.services')
	.factory('StudentClassService', StudentClassService);

function StudentClassService($http){
	var service = {};
	var serviceUrl = '/api/v1/';

	service.submitTips = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: serviceUrl + 'tip/student'
		});
	}
	service.submitHelp = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: serviceUrl + 'help-request'
		});
	}

	service.listTips = function(class_id, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'tip/student?class_id=' + class_id
				+ "&limit=" + table.size
				+ "&offset=" + table.offset
		});
	}


	return service;
}