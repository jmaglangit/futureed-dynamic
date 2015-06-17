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
	manageSubjectApi.getSubjectList = function(search, table) {
		return $http({
			  method : Constants.METHOD_GET
			, url 	 : manageSubjectApiUrl 
				+ 'subject?name=' + search.name
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
			  method : Constants.METHOD_DELETE
			, url 	 : manageSubjectApiUrl + 'subject/' + id
		});
	}

	return manageSubjectApi;
}