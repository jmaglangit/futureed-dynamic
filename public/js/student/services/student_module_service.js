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

	return moduleService;
}