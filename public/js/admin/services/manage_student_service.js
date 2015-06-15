angular.module('futureed.services')
	.factory('manageStudentService', manageStudentService);

function manageStudentService($http) {
	var adminApiUrl = '/api/v1/';
	var manageStudentApi = {};

	manageStudentApi.getStudentlist = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: adminApiUrl + 'admin/manage/student?name=' + search.name
				+ '&email=' + search.email
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}
	return manageStudentApi
}