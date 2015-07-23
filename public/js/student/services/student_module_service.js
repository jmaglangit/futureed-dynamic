angular.module('futureed.services')
	.factory('StudentModuleService', StudentModuleService);

StudentModuleService.$http = ['$http'];

function StudentModuleService($http){
	var service = {};
	var serviceUrl = '/api/v1/';

	service.addHelp = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: serviceUrl + 'help-request'
		})
	}

	service.list = function(data) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'help-request?module_id=' + data.module_id
				+ '&link_type=' + data.link_type
				+ '&student_id=' + data.student_id
				+ '&help_request_type=' + data.help_request_type
				+ '&question_status=' + data.question_status
				+ '&link_id=' + data.link_id
		});
	}

	service.getHelpDetails = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'help-request/' + id
		})
	}

	service.getHelpAnswer = function(id, status) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'help-request-answer?help_request_id=' + id
				+ '&request_answer_status=' + status
		})
	}

	service.submitAnswer = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: serviceUrl + 'help-request-answer'
		})
	}

	service.updateHelp = function(id, status) {
		return $http({
			method 	: Constants.METHOD_PATCH
			, data 	: {question_status: status}
			, url 	: serviceUrl + 'help-request/update-question-status/' + id
		})
	}

	return service;
}