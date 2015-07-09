angular.module('futureed.services')
	.factory('ManageModuleContentService', ManageModuleContentService);

ManageModuleContentService.$inject = ['$http'];

function ManageModuleContentService($http) {
	var service = {};
	var serviceUrl = '/api/v1/';

	service.list = function list(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url   : serviceUrl + 'teaching-content?teaching_module=' + search.teaching_module
				+ '&learning_style=' + search.learning_style
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

	service.delete = function(id) {
		return $http({
			method 	: Constants.METHOD_DELETE
			, url   : serviceUrl + 'tip/admin/' + id
		});
	}

	service.updateTipStatus = function(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data  : { tip_status : data.tip_status }
			, url   : serviceUrl + 'tip/update-status/' + data.id
		});
	}

	return service;
}