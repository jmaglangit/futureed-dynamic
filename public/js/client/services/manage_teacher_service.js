angular.module('futureed.services')
	.factory('manageTeacherService', manageTeacherService);

manageTeacherService.$inject = ['$http'];

function manageTeacherService($http){
	var manageTeacherApi = {};
	var teacherApiUrl = '/api/v1/';

	manageTeacherApi.list = function(search, table){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: teacherApiUrl + 'client/teacher?name=' + search.name
				+ '&email=' + search.email
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	manageTeacherApi.details = function(id){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: teacherApiUrl + 'client/teacher/'+ id
		});
	}

	manageTeacherApi.save = function(data){
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data 
			, url 	: teacherApiUrl + 'client/teacher'
		});
	}	


	return manageTeacherApi;
}