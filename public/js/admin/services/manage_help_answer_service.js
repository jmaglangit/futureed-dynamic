angular.module('futureed.services')
	.factory('ManageHelpAnswerService', ManageHelpAnswerService);

ManageHelpAnswerService.$inject = ['$http'];

function ManageHelpAnswerService($http) {
	var service = {};
	var serviceUrl = '/api/v1';

	service.list = function list(search, table) {
		return true;
	}

	return service;
}