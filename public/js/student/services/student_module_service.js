angular.module('futureed.services')
	.factory('StudentModuleService', StudentModuleService);

StudentModuleService.$http = ['$http'];

function StudentModuleService($http){
	var moduleService = {};
	var moduleServiceUrl = '/api/v1/';

	moduleService.addHelp = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: moduleServiceUrl + 'help-request'
		})
	}

	moduleService.currentList = function(data) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: moduleServiceUrl + 'help-request?module_id=' + data.module_id
				+ '&link_type=' + data.link_type
				+ '&student_id=' + data.student_id
				+ '&help_request_type=' + data.help_request_type
				+ '&question_status=' + data.question_status
				+ '&link_id=' + data.link_id
		});
	}

	return moduleService;
}