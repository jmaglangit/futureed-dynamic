angular.module('futureed.services')
	.factory('StudentTipsService', StudentTipsService);

StudentTipsService.$http = ['$http'];

function StudentTipsService($http){
	var service = {};
	var serviceUrl = '/api/v1/';

	service.list = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'tip/student?class_id=' + search.class_id
				+ "&area=" + search.area
				+ "&subject=" + search.subject
				+ "&limit=" + table.size
				+ "&offset=" + table.offset
		});
	}


	return service;
}