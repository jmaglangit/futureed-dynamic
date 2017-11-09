angular.module('futureed.services')
	.factory('ManageTeacherQuestionService', ManageTeacherQuestionService);

function ManageTeacherQuestionService($http){
	var apiUrl = '/api/v1/';
	var api = {};

	api.viewQuestion = function(search, table) {
		return $http({
			method 		: Constants.METHOD_GET
			, url 		: apiUrl + 'question?module_id=' + search.module_id
				+ '&difficulty=' + search.difficulty
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		})
	} 
	return api;
}
