angular.module('futureed.services')
	.factory('ManageGradeService', ManageGradeService);

ManageGradeService.$inject = ['$http'];

function ManageGradeService($http) {
	var api = {};
	var apiUrl = '/api/v1/';

	api.list = function(search, table) {
		return $http({
			method	: Constants.METHOD_GET
			, url 	: apiUrl + "grade?name=" + search.grade
				+ "&country_id=" + search.country_id
				+ "&limit=" + table.size
				+ "&offset=" + table.offset
		});
	}

	api.getCountryName = function(id) {
		return $http({
			method	: Constants.METHOD_GET
			, url 	: apiUrl + "countries/" + id
		});
	}

	api.add = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data	: data
			, url 	 : apiUrl + 'grade'
		});
	}

	api.details = function(id) {
		return $http({
			  method : Constants.METHOD_GET
			, url 	 : apiUrl + 'grade/' + id
		});
	}

	api.update = function(data) {
		return $http({
			  method : Constants.METHOD_PUT
			, data	 : data
			, url 	 : apiUrl + 'grade/' + data.id
		});
	}

	api.deleteGrade = function(id) {
		return $http({
			  method : Constants.METHOD_DELETE
			, url 	 : apiUrl + 'grade/' + id
		});
	}

	return api;
}