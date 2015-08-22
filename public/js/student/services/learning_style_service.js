angular.module('futureed.services')
	.factory('LearningStyleService', LearningStyleService);

function LearningStyleService($http) {
	var service = {};
	var serviceUrl = '/api/v1/assess/';

	service.getTest = function() {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'get-test'
		});
	}
	
	service.saveTest = function(test_id, section_id, user_answers, student_id) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: 
					{
						test_id: test_id,
						student_id: student_id,
						section_id: section_id,
						user_answers: user_answers
					}
			, url 	: serviceUrl + 'save-test'
		});
	}
	
	return service;
}