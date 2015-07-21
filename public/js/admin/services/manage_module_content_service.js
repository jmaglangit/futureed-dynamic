angular.module('futureed.services')
	.factory('ManageModuleContentService', ManageModuleContentService);

ManageModuleContentService.$inject = ['$http'];

function ManageModuleContentService($http) {
	var service = {};
	var serviceUrl = '/api/v1/';

	service.list = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url   : serviceUrl + 'teaching-content?teaching_module=' + search.teaching_module
				+ '&teaching_module_id=' + search.teaching_module_id
				+ '&learning_style=' + search.learning_style
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	service.getLearningStyle = function() {
		return $http({
			method 	: Constants.METHOD_GET
			, url   : serviceUrl + 'learning-style/admin'
		});
	}

	service.getMediaTypes = function() {
		return $http({
			method 	: Constants.METHOD_GET
			, url   : serviceUrl + 'media-type/admin'
		});
	}

	service.detail = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url   : serviceUrl + 'teaching-content/' + id
		});
	}

	service.update = function(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data	: data
			, url   : serviceUrl + 'teaching-content/' + data.id
		});
	}

	service.add = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data	: data
			, url   : serviceUrl + 'teaching-content'
		});
	}

	service.delete = function(id) {
		return $http({
			method 	: Constants.METHOD_DELETE
			, url   : serviceUrl + 'teaching-content/' + id
		});
	}

	return service;
}