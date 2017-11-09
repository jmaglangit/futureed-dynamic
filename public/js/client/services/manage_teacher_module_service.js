angular.module('futureed.services')
	.factory('ManageTeacherModuleService', ManageTeacherModuleService);

function ManageTeacherModuleService($http){
	var url = '/api/v1/';
	var service = {};

	service.listModule = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: url + 'module?name=' + search.name
				+ '&subject=' + search.subject
				+ '&grade_id=' + search.grade_id
				+ '&country_id=' + search.country_id
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		})
	}

	service.getSubject = function() {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: url + 'subject?status=Enabled'
		})
	}

	service.detail = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: url + 'module/' + id
		})
	}

	//api/v1/client/teacher/curriculum-country/{id}
	service.getCurriculumCountry = function(client_id){
		return $http({
			method	:	Constants.METHOD_GET,
			url		:	url + 'client/teacher/curriculum-country/' + client_id
		});
	}
	return service;
}