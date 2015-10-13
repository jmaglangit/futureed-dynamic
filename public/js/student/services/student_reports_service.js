angular.module('futureed.services')
	.factory('StudentReportsService', StudentReportsService);

StudentReportsService.$http = ['$http'];

function StudentReportsService($http) {
	var api = {};
	var apiUrl = '/api/';

	api.reportCard = function(id) {
		return $http({
			method : Constants.METHOD_GET
			, url  : apiUrl + 'report/student/' + id
		});
	}

	api.summaryProgress = function(id) {
		return $http({
			method : Constants.METHOD_GET
			, url  : apiUrl + 'report/student-progress/' + id
		});
	}
	
	return api;	
}