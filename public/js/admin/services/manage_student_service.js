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

	manageStudentApi.saveEdit = function(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data 	: data
			, url 	: adminApiUrl + 'admin/manage/student/' + data.id
		});
	}

	manageStudentApi.deleteStudent = function(id) {
		return $http({
			method 	: Constants.METHOD_DELETE
			, url 	: adminApiUrl + 'admin/manage/student/' + id
		});
	}

	manageStudentApi.moduleList = function(id) {
		return $http({
			method 	: Constants.METHOD_GET	
			, url 	: adminApiUrl + 'module/student?student_id=' + id
		});
	}

	manageStudentApi.resetModule = function(id) {
		return $http({
			method 	: Constants.METHOD_PUT	
			, url 	: adminApiUrl + 'reset/student-module/' + id
		});
	}
	return manageStudentApi
}