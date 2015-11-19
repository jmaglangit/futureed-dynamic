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

	// /api/v1/client/manage/student?client_id={id of client}&name=&email=&limit=&offset=0
	service.listStudents = function(client_id){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: url + 'client/manage/student?client_id='+client_id
			+ '&offset=0'
		})
	}
	return service;
}