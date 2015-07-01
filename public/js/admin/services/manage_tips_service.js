angular.module('futureed.services')
	.factory('ManageTipsService', ManageTipsService);

ManageTipsService.$inject = ['$http'];

function ManageTipsService($http) {
	var service = {};
	var serviceUrl = '/api/v1';

	service.list = function list(search, table) {
		return true;
	}

	return service;
}