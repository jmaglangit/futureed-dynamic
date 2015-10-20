angular.module('futureed.services')
	.factory('ManageAgeGroupService', ManageAgeGroupService);

ManageAgeGroupService.$inject = ['$http'];

function ManageAgeGroupService($http) {
	var api = {};
	var apiUrl = '/api/v1/';

	api.getAges = function() {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: apiUrl + 'age-group'
		});
	}

	api.add = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: apiUrl + 'module-group'
		});
	}

	api.details = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: apiUrl + 'module-group/' + id
		});
	}

	api.update  = function(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data 	: data
			, url 	: apiUrl + 'module-group/' + data.id
		});
	}

	api.deleteAgeGroup  = function(id) {
		return $http({
			method 	: Constants.METHOD_DELETE
			, url 	: apiUrl + 'module-group/' + id
		});
	}

	api.list = function(module, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: apiUrl + 'module-group?module_id=' + module
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	return api;

}
