angular.module('futureed.services')
	.factory('manageModuleService', manageModuleService);

manageModuleService.$inject = ['$http'];

function manageModuleService($http) {
	var moduleServiceApi = {};
	var moduleServiceUrl = '/api/v1/';

	moduleServiceApi.list = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: moduleServiceUrl + 'module/admin?subject=' + search.subject
				+ '&name=' + search.name
				+ '&area=' + search.area
				+ '&limit' + table.size
				+ '&offset' + table.offset
		});
	}

	return moduleServiceApi
}