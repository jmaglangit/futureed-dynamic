angular.module('futureed.services')
	.factory('managePrincipalTeacherService', managePrincipalTeacherService);

managePrincipalTeacherService.$inject = ['$http'];

function managePrincipalTeacherService($http){
	var manageTeacherApi = {};
	var teacherApiUrl = '/api/v1/';

	manageTeacherApi.list = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: teacherApiUrl + 'client/teacher?name=' + search.name
				+ '&email=' + search.email
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	manageTeacherApi.details = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: teacherApiUrl + 'client/teacher/'+ id
		});
	}

	manageTeacherApi.classDetails = function(id, table) {
		return $http({
			method  : Constants.METHOD_GET
			, url 	: teacherApiUrl + 'classroom?client_id=' + id
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	manageTeacherApi.update = function(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data	: data
			, url 	: teacherApiUrl + 'client/teacher/'+ data.id
		});
	}

	manageTeacherApi.save = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data 
			, url 	: teacherApiUrl + 'client/teacher'
		});
	}	

	manageTeacherApi.delete = function(id) {
		return $http({
			method 	: Constants.METHOD_DELETE
			, url 	: teacherApiUrl + 'client/teacher/' + id
		});
	}


	return manageTeacherApi;
}