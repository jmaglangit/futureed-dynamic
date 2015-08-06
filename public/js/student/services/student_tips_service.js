angular.module('futureed.services')
	.factory('StudentTipsService', StudentTipsService);

StudentTipsService.$http = ['$http'];

function StudentTipsService($http){
	var service = {};
	var serviceUrl = '/api/v1/';

	service.list = function(search, table) {
		var params = Constants.EMPTY_STR;

			if(search.module_id) {
				params += "link_id=" + search.link_id + "&link_type=" + search.link_type + "&module_id=" + search.module_id	
			} else {
				params += "class_id=" + search.class_id + "&area=" + search.area + "&subject=" + search.subject;
				params += "&limit=" + table.size + "&offset=" + table.offset;
			}

		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'tip/student?' + params
		});
	}

	service.addTip = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: serviceUrl + 'tip/question-content'
		})
	}

	service.detail = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'tip/student/' + id
		});
	}

	service.rate = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data  : data
			, url 	: serviceUrl + 'tip-rating/student'
		});
	}

	return service;
}