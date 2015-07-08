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

	moduleServiceApi.getSubject = function() {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: moduleServiceUrl + 'subject'
		});
	}

	moduleServiceApi.searchArea = function(id, name) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: moduleServiceUrl + 'subject-area?subject_id=' + id
				+ '&name=' + name
		});
	}

	moduleServiceApi.addNewModule  = function(data){
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: moduleServiceUrl + 'module/admin'
		});
	}

	moduleServiceApi.getModuleDetail  = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: moduleServiceUrl + 'module/admin/' + id
		});
	}

	moduleServiceApi.saveModule  = function(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data 	: data
			, url 	: moduleServiceUrl + 'module/admin/' + data.id
		});
	}

	moduleServiceApi.deleteModule  = function(id) {
		return $http({
			method 	: Constants.METHOD_DELETE
			, url 	: moduleServiceUrl + 'module/admin/' + id
		});
	}

	moduleServiceApi.ageModuleList = function(module, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: moduleServiceUrl + 'module-group?module_name=' + module
				+ '&limit' + table.size
				+ '&offset' + table.offset
		});
	}

	return moduleServiceApi
}