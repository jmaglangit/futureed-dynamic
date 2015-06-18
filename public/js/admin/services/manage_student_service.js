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

	manageStudentApi.save = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: adminApiUrl + 'admin/manage/student'
		})
	}

	/**
	* Search School
	*
	* @Param
	*		school_name		- [Optiona] the school name
	*/
	manageStudentApi.searchSchool = function(school_name) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: adminApiUrl + 'school/search?school_name=' + school_name
		});
	}

	manageStudentApi.viewStudent = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: adminApiUrl + 'admin/manage/student/' + id
		});
	}
	return manageStudentApi
}