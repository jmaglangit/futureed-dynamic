angular.module('futureed.services')
	.factory('StudentHelpService', StudentHelpService);

StudentHelpService.$http = ['$http'];

function StudentHelpService($http){
	var service = {};
	var serviceUrl = '/api/v1/';

	service.list = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'help-request?class_id=' + search.class_id
					+ "&question_status=" + search.question_status
					+ "&subject=" + search.subject
					+ "&student_id=" + search.student_id
					+ "&help_request_type=" + search.help_request_type
					+ "&limit=" + table.size
					+ "&offset=" + table.offset
		});
	}

	service.detail = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'help-request/' + id
		});
	}

	service.rate = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data  : data
			, url 	: serviceUrl + 'help-request-rating /student'
		});
	}

	return service;
}