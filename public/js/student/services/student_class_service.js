angular.module('futureed.services')
	.factory('StudentClassService', StudentClassService);

function StudentClassService($http){
	var classApiUrl = '/api/v1/';
	var studentClassApi = {};

	studentClassApi.submitTips = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: classApiUrl + 'tip/student'
		});
	}
	


	return studentClassApi;
}