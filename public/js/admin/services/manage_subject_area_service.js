angular.module('futureed.services')
	.factory('manageSubjectAreaService', manageSubjectAreaService);

manageSubjectAreaService.$inject = ['$http'];

function manageSubjectAreaService($http) {
	var api = {};
	var url = '/api/v1/';

	/**
	* Get Subject Area List
	*
	* @Param
	*		id 		- [Required] the subject id
	*		name 	- [Optional] the area name
	*/
	api.list = function(search, table) {
		return $http({
			  method : Constants.METHOD_GET
			, url 	 : url 
				+ 'subject-area?subject_id=' + search.subject_id 
				+ '&name=' + search.name
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
	api.add = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data	: data
			, url 	 : url + 'subject-area'
		});
	}

	/**
	* Get Subject Area Details
	*
	* @Param
	*		id 	- [Required] the area id
	*/
	api.details = function(id) {
		return $http({
			  method : Constants.METHOD_GET
			, url 	 : url + 'subject-area/' + id
		});
	}

	/**
	* Update Subject Area Details
	*
	* @Param
	*		data 	- [Required] the updated area data (subject_id, code, name, status)
	*/
	api.update = function(data) {
		return $http({
			  method : Constants.METHOD_PUT
			, data	 : data
			, url 	 : url + 'subject-area/' + data.id
		});
	}

	/**
	* Delete Subject Area
	*
	* @Param
	*		id 	- [Required] the area id
	*/
	api.delete = function(id) {
		return $http({
			  method : Constants.METHOD_DELETE
			, url 	 : url + 'subject-area/' + id
		});
	}

	return api;
}