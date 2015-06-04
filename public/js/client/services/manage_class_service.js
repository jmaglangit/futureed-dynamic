angular.module('futureed.services')
	.factory('manageClassService', manageClassService);

manageClassService.$inject = ['$http'];

function manageClassService($http){
	var manageClassApi = {};
	var classApiUrl = '/api/v1/';
	
	manageClassApi.list = function(search, table) {
		return $http({
			method : Constants.METHOD_GET
			, url  : classApiUrl + 'classroom?name=' + search.name
				+ '&grade_id=' + search.grade_id
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	return manageClassApi;
}