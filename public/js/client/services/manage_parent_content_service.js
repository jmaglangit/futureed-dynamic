angular.module('futureed.services')
	.factory('ManageParentContentService', ManageParentContentService);

function ManageParentContentService($http){
	var url = '/api/v1/';
	var service = {};

	service.listContent = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: url + 'teaching-content?teaching_module_id=' + id
		})
	}

	service.getContent = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: url + 'teaching-content/' + id
		})
	}
	return service;
}