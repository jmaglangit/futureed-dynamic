angular.module('futureed.services')
	.factory('ManageParentModuleService', ManageParentModuleService);

function ManageParentModuleService($http){
	var url = '/api/v1/';
	var service = {};

	service.listModule = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: url + 'module?name=' + search.name
				+ '&subject=' + search.subject
				+ '&age_group_id=' + search.grade_id
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		})
	}

	service.getSubject = function() {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: url + 'subject'
		})
	}

	service.detail = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: url + 'module/' + id
		})
	}

	return service;
}