angular.module('futureed.services')
	.factory('ManageTeacherTipsService', ManageTeacherTipsService);

function ManageTeacherTipsService($http){
	var url = '/api/v1/';
	var service = {};

	service.list = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: url + 'tip/teacher?class_id=' + search.class_id
				+ '&title=' + search.title
				+ '&status=' + search.status
				+ '&created=' + search.created
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	service.detail = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: url + 'tip/teacher/' + id
		});
	}

	service.update = function(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data 	: data
			, url 	: url + 'tip/teacher/' + data.id
		});
	}

	service.updateStatus = function(id, status) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data 	: {tip_status : status}
			, url 	: url + 'tip/update-status/' + id
		});
	}

	return service;
}