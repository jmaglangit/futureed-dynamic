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

	service.listHelpRequests = function(id, search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'help-request?class_id=' + id
				+ "&order_by_date=" + search.order_by_date
				+ "&request_status=" + search.request_status
				+ "&limit=" + table.size
				+ "&offset=" + table.offset
		});
	}


	return service;
}