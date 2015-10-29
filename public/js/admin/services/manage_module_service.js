angular.module('futureed.services')
	.factory('ManageModuleService', ManageModuleService);

ManageModuleService.$inject = ['$http'];

function ManageModuleService($http) {
	var api = {};
	var apiUrl = '/api/v1/';

	api.list = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: apiUrl + 'module/admin?subject=' + search.subject
				+ '&name=' + search.name
				+ '&area=' + search.area
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	api.getSubject = function() {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: apiUrl + 'subject'
		});
	}

	api.searchArea = function(id, name) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: apiUrl + 'subject-area?subject_id=' + id
				+ '&name=' + name
		});
	}

	api.add  = function(data){
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: apiUrl + 'module/admin'
		});
	}

	api.details  = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: apiUrl + 'module/admin/' + id
		});
	}

	api.update  = function(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data 	: data
			, url 	: apiUrl + 'module/admin/' + data.id
		});
	}

	api.deleteModule  = function(id) {
		return $http({
			method 	: Constants.METHOD_DELETE
			, url 	: apiUrl + 'module/admin/' + id
		});
	}

	return api
}