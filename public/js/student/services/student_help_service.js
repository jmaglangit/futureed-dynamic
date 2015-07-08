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
					+ "&request_status=" + search.request_status
					+ "&subject=" + search.subject
					+ "&student_id=" + search.student_id
					+ "&help_request_type=" + search.help_request_type
					+ "&limit=" + table.size
					+ "&offset=" + table.offset
		});
	}

	service.listAnswers = function(help_request_id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'help-request-answer?help_request_id=' + help_request_id
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
			, url 	: serviceUrl + 'help-request-answer-rating'
		});
	}

	service.updateStatus = function(data) {
		return $http({
			method 	: Constants.METHOD_PATCH
			, url 	: serviceUrl + 'help-request/update-question-status/' + data.id + "?question_status=" + data.question_status
		});
	}

	return service;
}