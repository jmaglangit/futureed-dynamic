angular.module('futureed.services')
	.factory('ManageTeacherContentService', ManageTeacherContentService);

function ManageTeacherContentService($http){
	var url = '/api/v1/';
	var service = {};

	service.listContent = function(id, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: url + 'teaching-content?teaching_module_id=' + id
				+ '&limit=' + table.size 
				+ '&offset=' + table.offset
		})
	}

	service.selectAllContents = function(id) {
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

	service.getClassReport = function(id) {
		return $http({
			method : Constants.METHOD_GET
			, url  : '/api/report/classroom/' + id
		});
	}

	service.getClassList = function(id) {
		return $http({
			method : Constants.METHOD_GET
			, url  : url + 'classroom?client_id=' + id
			+ '&payment_status=' + 'Paid'
			+ '&offset=' + '0'
		});
	}

	return service;
}