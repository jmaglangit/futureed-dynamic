angular.module('futureed.services')
	.factory('manageClassService', manageClassService);

manageClassService.$inject = ['$http'];

function manageClassService($http){
	var manageClassApi = {};
	var classApiUrl = '/api/v1/';
	
	manageClassApi.list = function(search, table) {
		return $http({
			method : Constants.METHOD_GET
			, url  : classApiUrl + 'classroom?name=' + search.name
				+ '&grade_id=' + search.grade_id
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	manageClassApi.studentList = function(search) {
		return $http({
			method : Constants.METHOD_GET
			, url  : classApiUrl + 'classroom/' + search.id + '/students?name=' + search.name
				+ '&email=' + search.email
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

	return manageClassApi;
}