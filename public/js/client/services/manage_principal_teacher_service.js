angular.module('futureed.services')
	.factory('ManagePrincipalTeacherService', ManagePrincipalTeacherService);

ManagePrincipalTeacherService.$inject = ['$http'];

function ManagePrincipalTeacherService($http){
	var api = {};
	var apiUrl = '/api/v1/';

	api.list = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: apiUrl + 'client/teacher?name=' + search.name
				+ '&school_code=' + search.school_code
				+ '&email=' + search.email
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	api.details = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: apiUrl + 'client/teacher/'+ id
		});
	}

	api.classDetails = function(id, table) {
		return $http({
			method  : Constants.METHOD_GET
			, url 	: apiUrl + 'classroom?client_id=' + id
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	api.update = function(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data	: data
			, url 	: apiUrl + 'client/teacher/'+ data.id
		});
	}

	api.save = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data 
			, url 	: apiUrl + 'client/teacher'
		});
	}	

	api.delete = function(id) {
		return $http({
			method 	: Constants.METHOD_DELETE
			, url 	: apiUrl + 'client/teacher/' + id
		});
	}

	return api;
}