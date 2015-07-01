angular.module('futureed.services')
	.factory('ManageHelpRequestService', ManageHelpRequestService);

ManageHelpRequestService.$inject = ['$http'];

function ManageHelpRequestService($http) {
	var service = {};
	var serviceUrl = '/api/v1';

	service.list = function list(search, table) {
		return true;
	}

	return service;
}