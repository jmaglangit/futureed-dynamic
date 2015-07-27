angular.module('futureed.services')
	.factory('ManageTeacherQuestionService', ManageTeacherQuestionService);

function ManageTeacherQuestionService($http){
	var url = '/api/v1/';
	var service = {};

	service.viewQuestion = function(data) {
		return $http({
			method 		: Constants.METHOD_GET
			, url 		: url + 'question?module_id=' + data.id
				+ '&limit=' + data.limit
				+ '&offset=' + data.offset
		})
	} 
	return service;
}
