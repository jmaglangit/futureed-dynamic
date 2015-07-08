angular.module('futureed.services')
	.factory('manageGradeService', manageGradeService);

manageGradeService.$inject = ['$http'];

function manageGradeService($http) {
	var service = {};
	var serviceUrl = '/api/v1/';

	service.getGradeList = function(search, table) {
		return $http({
			method	: Constants.METHOD_GET
			, url 	: serviceUrl + "grade?name=" + search.grade
				+ "&country_id=" + search.country_id
				+ "&limit=" + table.size
				+ "&offset=" + table.offset
		});
	}

	service.getCountryName = function(id) {
		return $http({
			method	: Constants.METHOD_GET
			, url 	: serviceUrl + "countries/" + id
		});
	}

	service.addNewGrade = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data	: data
			, url 	 : serviceUrl + 'grade'
		});
	}

	service.getGradeDetails = function(id) {
		return $http({
			  method : Constants.METHOD_GET
			, url 	 : serviceUrl + 'grade/' + id
		});
	}

	service.updateGradeDetails = function(data) {
		return $http({
			  method : Constants.METHOD_PUT
			, data	 : data
			, url 	 : serviceUrl + 'grade/' + data.id
		});
	}

	service.deleteGrade = function(id) {
		return $http({
			  method : Constants.METHOD_DELETE
			, url 	 : serviceUrl + 'grade/' + id
		});
	}

	return service;
}