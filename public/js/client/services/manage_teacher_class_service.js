angular.module('futureed.services')
	.factory('ManageClassService', ManageClassService);

ManageClassService.$inject = ['$http'];

function ManageClassService($http){
	var manageClassApi = {};
	var classApiUrl = '/api/v1/';
	
	manageClassApi.list = function(search, table) {
		return $http({
			method : Constants.METHOD_GET
			, url  : classApiUrl + 'classroom?name=' + search.name
				+ '&client_id=' + search.client_id
				+ '&grade_id=' + search.grade_id
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	manageClassApi.studentList = function(search, table) {
		return $http({
			method : Constants.METHOD_GET
			, url  : classApiUrl + 'classroom/' + search.id + '/students?name=' + search.name
				+ '&email=' + search.email
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	manageClassApi.details = function(id) {
		return $http({
			method : Constants.METHOD_GET
			, url  : classApiUrl + 'classroom/' + id
		});
	}

	manageClassApi.update = function(data) {
		return $http({
			method : Constants.METHOD_PUT
			, data : {name : data.name}
			, url  : classApiUrl + 'classroom/' + data.id
		});
	}

	manageClassApi.addExistingStudent = function(data) {
		return $http({
			method : Constants.METHOD_POST
			, data : data
			, url  : classApiUrl + 'class-student/add-existing-student'
		});
	}

	manageClassApi.addNewStudent = function(data) {
		return $http({
			method : Constants.METHOD_POST
			, data : data
			, url  : classApiUrl + 'class-student/add-new-student'
		});
	}

	manageClassApi.getSchoolDetails = function(code) {
		return $http({
			method : Constants.METHOD_GET
			, url  : classApiUrl + 'school/' + code
		});
	}

	manageClassApi.deleteStudent = function(data) {
		return $http({
			method : Constants.METHOD_PUT
			, data : {date_removed : data.date_removed}
			, url  : classApiUrl + 'class-student/student-remove-class/' + data.id
		});
	}

	return manageClassApi;
}