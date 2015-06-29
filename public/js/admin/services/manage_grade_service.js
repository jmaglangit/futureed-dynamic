angular.module('futureed.services')
	.factory('manageGradeService', manageGradeService);

manageGradeService.$inject = ['$http'];

function manageGradeService($http) {

	var manageGradeApi = {};
	var manageGradeApiUrl = '/api/v1/';

	manageGradeApi.getGradeList = function(grade, country_id, table) {
		return $http({
			method	: Constants.METHOD_GET
			, url 	: manageGradeApiUrl + "grade?name=" + grade
				+ "&country_id=" + country_id
				+ "&limit=" + table.size
				+ "&offset=" + table.offset
		});
	}

	manageGradeApi.getCountryName = function(id) {
		return $http({
			method	: Constants.METHOD_GET
			, url 	: manageGradeApiUrl + "countries/" + id
		});
	}

	manageGradeApi.addNewGrade = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data	: data
			, url 	 : manageGradeApiUrl + 'grade'
		});
	}

	manageGradeApi.getGradeDetails = function(id) {
		return $http({
			  method : Constants.METHOD_GET
			, url 	 : manageGradeApiUrl + 'grade/' + id
		});
	}

	manageGradeApi.updateGradeDetails = function(data) {
		return $http({
			  method : Constants.METHOD_PUT
			, data	 : data
			, url 	 : manageGradeApiUrl + 'grade/' + data.id
		});
	}

	manageGradeApi.deleteGrade = function(id) {
		return $http({
			  method : 'DELETE'
			, url 	 : manageGradeApiUrl + 'grade/' + id
		});
	}

	return manageGradeApi;
}