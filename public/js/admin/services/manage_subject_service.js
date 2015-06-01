angular.module('futureed.services')
	.factory('manageSubjectService', manageSubjectService);

manageSubjectService.$inject = ['$http'];

function manageSubjectService($http) {
	var manageSubjectApi = {};
	var manageSubjectApiUrl = '/api/v1/';

	/**
	* Get Subject List
	* 
	* @Param
	*		name - [Optional] the subject name
	*/
	manageSubjectApi.getSubjectList = function(subject_name, table) {
		subject_name = (subject_name) ? subject_name : '';

		return $http({
			  method : Constants.METHOD_GET
			, url 	 : manageSubjectApiUrl 
				+ 'subject?name=' + subject_name
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	/**
	* Add New Subject
	*
	* @Param
	*		data - [Required] the subject data (code, name, description, status)
	*/
	manageSubjectApi.addNewSubject = function(data) {
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
	manageSubjectApi.getSubjectDetails = function(id) {
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
	manageSubjectApi.updateSubjectDetails = function(data) {
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
	manageSubjectApi.deleteSubject = function(id) {
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
	manageSubjectApi.getSubjectAreaList = function(id, area_name, table) {
		return $http({
			  method : Constants.METHOD_GET
			, url 	 : manageSubjectApiUrl 
				+ 'subject-area?subject_id=' + id 
				+ '&name=' + area_name
				+ '&limit=' + table.size
				+ '&offset=' +table.offset 
		}); 
	}

	/**
	* Add New Subject Area
	*
	* @Param
	*		data 	- [Required] the area data (subject_id, code, name, status)
	*/
	manageSubjectApi.addNewSubjectArea = function(data) {
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
	manageSubjectApi.getSubjectAreaDetails = function(id) {
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
	manageSubjectApi.updateSubjectAreaDetails = function(data) {
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
	manageSubjectApi.deleteSubjectArea = function(id) {
		return $http({
			  method : 'DELETE'
			, url 	 : manageSubjectApiUrl + 'subject-area/' + id
		});
	}

	return manageSubjectApi;
}