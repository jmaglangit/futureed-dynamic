angular.module('futureed.services')
	.factory('manageSubjectService', manageSubjectService);

manageSubjectService.$inject = ['$http'];

function manageSubjectService($http) {

	var manageSubjectApi = {};
	var manageSubjectApiUrl = '/api/v1/';

	manageSubjectApi.getSubjectList = getSubjectList;
	manageSubjectApi.addNewSubject = addNewSubject;
	manageSubjectApi.getSubjectDetails = getSubjectDetails;
	manageSubjectApi.updateSubjectDetails = updateSubjectDetails;
	manageSubjectApi.deleteSubject = deleteSubject;

	function getSubjectList(subject_name) {
		subject_name = (subject_name) ? subject_name : '';

		return $http({
			  method : Constants.METHOD_GET
			, url 	 : manageSubjectApiUrl + 'subject?name=' + subject_name
		});
	}

	function addNewSubject(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data	: data
			, url 	 : manageSubjectApiUrl + 'subject'
		});
	}

	function getSubjectDetails(id) {
		return $http({
			  method : Constants.METHOD_GET
			, url 	 : manageSubjectApiUrl + 'subject/' + id
		});
	}

	function updateSubjectDetails(data) {
		return $http({
			  method : Constants.METHOD_PUT
			, data	 : data
			, url 	 : manageSubjectApiUrl + 'subject/' + data.id
		});
	}

	function deleteSubject(id) {
		return $http({
			  method : 'DELETE'
			, url 	 : manageSubjectApiUrl + 'subject/' + id
		});
	}

	return manageSubjectApi;
}