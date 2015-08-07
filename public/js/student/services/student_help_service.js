angular.module('futureed.services')
	.factory('StudentHelpService', StudentHelpService);

StudentHelpService.$http = ['$http'];

function StudentHelpService($http){
	var service = {};
	var serviceUrl = '/api/v1/';

	service.list = function(search, table) {
		var params = Constants.EMPTY_STR;

		if(search.module_id) {
			params += 'module_id=' + search.module_id
					+ '&link_type=' + search.link_type
					+ '&student_id=' + search.student_id
					+ '&help_request_type=' + search.help_request_type
					+ '&question_status=' + search.question_status
					+ '&link_id=' + search.link_id
		} else {
			params += 'class_id=' + search.class_id 
					+ "&title=" + search.title
					+ "&student_id=" + search.student_id
					+ "&request_status=" + search.request_status 
					+ "&help_request_type=" + search.help_request_type
		}

		if(table) {
			params += "&limit=" + table.size + "&offset=" + table.offset
		}

		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'help-request?' + params
					
		});
	}

	service.listAnswers = function(help_request_id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'help-request-answer?help_request_id=' + help_request_id
				+ "&request_answer_status=" + Constants.ACCEPTED
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

	service.answerRequest = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data  : data
			, url 	: serviceUrl + 'help-request-answer'
		});
	}
	
	return service;
}