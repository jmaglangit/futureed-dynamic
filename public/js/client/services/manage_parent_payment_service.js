angular.module('futureed.services')
	.factory('ManageParentPaymentService', ManageParentPaymentService);

function ManageParentPaymentService($http){
	var paymentApiUrl = '/api/v1/';
	var managePaymentApi = {};
	
	managePaymentApi.list = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: paymentApiUrl + 'invoice?client_id=' + search.client_id
		});
	}

	return managePaymentApi;
}