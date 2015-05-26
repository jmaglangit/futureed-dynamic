angular.module('futureed.services')
	.factory('manageSubjectService', manageSubjectService);

manageSubjectService.$inject = ['$http'];

function manageSubjectService($http) {
	var manageSubjectApi = {};
	var manageSubjectApiUrl = '/api/v1/';

	/**
	* Subject API Calls
	*/
	manageSubjectApi.getSubjectList = getSubjectList;
	manageSubjectApi.addNewSubject = addNewSubject;

	manageSubjectApi.getSubjectDetails = getSubjectDetails;
	manageSubjectApi.updateSubjectDetails = updateSubjectDetails;

	manageSubjectApi.deleteSubject = deleteSubject;

	/**
	* Subject Area API Calls
	*/
	manageSubjectApi.getSubjectAreaList = getSubjectAreaList;
	manageSubjectApi.addNewSubjectArea = addNewSubjectArea;
	
	manageSubjectApi.getSubjectAreaDetails = getSubjectAreaDetails;
	manageSubjectApi.updateSubjectAreaDetails = updateSubjectAreaDetails;

	manageSubjectApi.deleteSubjectArea = deleteSubjectArea;

	/**
	* Get Subject List
	* 
	* @Param
	*		name - [Optional] the subject name
	*/
	function getSubjectList(subject_name) {
		subject_name = (subject_name) ? subject_name : '';

		return $http({
			  method : Constants.METHOD_GET
			, url 	 : manageSubjectApiUrl + 'subject?name=' + subject_name
		});
	}

	/**
	* Add New Subject
	*
	* @Param
	*		data - [Required] the subject data (code, name, description, status)
	*/
	function addNewSubject(data) {
		return $http({
			method 	 : Constants.METHOD_POST
			, data	 : data
			, url 	 : manageSubjectApiUrl + 'subject'
		});
	}

	/**
	* Get Subject Details
	*
	* @Param
	*		id 	- [Required] the subject id
	*/
	function getSubjectDetails(id) {
		return $http({
			  method : Constants.METHOD_GET
			, url 	 : manageSubjectApiUrl + 'subject/' + id
		});
	}

	/**
	* Update Subject Details
	*
	* @Param
	*		data - [Required] the updated subject data (code, name, description, status)
	*/
	function updateSubjectDetails(data) {
		return $http({
			  method : Constants.METHOD_PUT
			, data	 : data
			, url 	 : manageSubjectApiUrl + 'subject/' + data.id
		});
	}

	/**
	* Delete Subject
	*
	* @Param
	*		id 	- [Required] the subject id
	*/
	function deleteSubject(id) {
		return $http({
			  method : 'DELETE'
			, url 	 : manageSubjectApiUrl + 'subject/' + id
		});
	}

	/**
	* Get Subject Area List
	*
	* @Param
	*		id 		- [Required] the subject id
	*		name 	- [Optional] the area name
	*/
	function getSubjectAreaList(id, area_name) {
		area_name = (area_name) ? area_name : '';

		return $http({
			  method : Constants.METHOD_GET
			, url 	 : manageSubjectApiUrl + 'subject-area?subject_id=' + id + '&name=' + area_name
		}); 
	}

	/**
	* Add New Subject Area
	*
	* @Param
	*		data 	- [Required] the area data (subject_id, code, name, status)
	*/
	function addNewSubjectArea(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data	: data
			, url 	 : manageSubjectApiUrl + 'subject-area'
		});
	}

	/**
	* Get Subject Area Details
	*
	* @Param
	*		id 	- [Required] the area id
	*/
	function getSubjectAreaDetails(id) {
		return $http({
			  method : Constants.METHOD_GET
			, url 	 : manageSubjectApiUrl + 'subject-area/' + id
		});
	}

	/**
	* Update Subject Area Details
	*
	* @Param
	*		data 	- [Required] the updated area data (subject_id, code, name, status)
	*/
	function updateSubjectAreaDetails(data) {
		return $http({
			  method : Constants.METHOD_PUT
			, data	 : data
			, url 	 : manageSubjectApiUrl + 'subject-area/' + data.id
		});
	}

	/**
	* Delete Subject Area
	*
	* @Param
	*		id 	- [Required] the area id
	*/
	function deleteSubjectArea(id) {
		return $http({
			  method : 'DELETE'
			, url 	 : manageSubjectApiUrl + 'subject-area/' + id
		});
	}

	return manageSubjectApi;
}