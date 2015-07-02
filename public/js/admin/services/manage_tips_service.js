angular.module('futureed.services')
	.factory('ManageTipsService', ManageTipsService);

ManageTipsService.$inject = ['$http'];

function ManageTipsService($http) {
	var service = {};
	var serviceUrl = '/api/v1/';

	service.list = function list(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url   : serviceUrl + 'tip/admin?status=' + search.status
				+ '&link_type=' + search.link_type
				+ '&module=' + search.module
				+ '&area=' + search.area
				+ '&subject=' + search.subject
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	service.detail = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url   : serviceUrl + 'tip/admin/' + id
		});
	}

	service.update = function(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data	: data
			, url   : serviceUrl + 'tip/admin/' + data.id
		});
	}

	return service;
}