angular.module('futureed.services')
	.factory('ManageSubjectService', ManageSubjectService);

ManageSubjectService.$inject = ['$http'];

function ManageSubjectService($http) {
	var api = {};
	var apiUrl = '/api/v1/';

	/**
	* Get Subject List
	* 
	* @Param
	*		name - [Optional] the subject name
	*/
	api.getSubjectList = function(search, table) {
		return $http({
			  method : Constants.METHOD_GET
			, url 	 : apiUrl 
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
	api.add = function(data) {
		return $http({
			method 	 : Constants.METHOD_POST
			, data	 : data
			, url 	 : apiUrl + 'subject'
		});
	}

	/**
	* Get Subject Details
	*
	* @Param
	*		id 	- [Required] the subject id
	*/
	api.details = function(id) {
		return $http({
			  method : Constants.METHOD_GET
			, url 	 : apiUrl + 'subject/' + id
		});
	}

	/**
	* Update Subject Details
	*
	* @Param
	*		data - [Required] the updated subject data (code, name, description, status)
	*/
	api.update = function(data) {
		return $http({
			  method : Constants.METHOD_PUT
			, data	 : data
			, url 	 : apiUrl + 'subject/' + data.id
		});
	}

	/**
	* Delete Subject
	*
	* @Param
	*		id 	- [Required] the subject id
	*/
	api.deleteSubject = function(id) {
		return $http({
			  method : Constants.METHOD_DELETE
			, url 	 : apiUrl + 'subject/' + id
		});
	}

	return api;
}