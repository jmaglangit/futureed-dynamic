angular.module('futureed.services')
	.factory('manageGradeService', manageGradeService);

manageGradeService.$inject = ['$http'];

function manageGradeService($http) {

	var manageGradeApi = {};
	var manageGradeApiUrl = '/api/v1/';

	manageGradeApi.getGradeList = getGradeList;
	manageGradeApi.getCountryName = getCountryName;
	manageGradeApi.addNewGrade = addNewGrade;

	manageGradeApi.getGradeDetails = getGradeDetails;
	manageGradeApi.updateGradeDetails = updateGradeDetails;

	manageGradeApi.deleteGrade = deleteGrade;

	function getGradeList(grade, country) {
		return $http({
			method	: Constants.METHOD_GET
			, url 	: manageGradeApiUrl + "grade?name=" + grade
				+ "&country_id=" + country
		});
	}

	function getCountryName(id) {
		return $http({
			method	: Constants.METHOD_GET
			, url 	: manageGradeApiUrl + "countries/" + id
		});
	}

	function addNewGrade(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data	: data
			, url 	 : manageGradeApiUrl + 'grade'
		});
	}

	function getGradeDetails(id) {
		return $http({
			  method : Constants.METHOD_GET
			, url 	 : manageGradeApiUrl + 'grade/' + id
		});
	}

	function updateGradeDetails(data) {
		return $http({
			  method : Constants.METHOD_PUT
			, data	 : data
			, url 	 : manageGradeApiUrl + 'grade/' + data.id
		});
	}

	function deleteGrade(id) {
		return $http({
			  method : 'DELETE'
			, url 	 : manageGradeApiUrl + 'grade/' + id
		});
	}

	return manageGradeApi;
}