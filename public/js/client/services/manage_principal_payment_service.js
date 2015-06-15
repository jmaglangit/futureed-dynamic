angular.module('futureed.services')
	.factory('managePrincipalPaymentService', managePrincipalPaymentService);

function managePrincipalPaymentService($http){
	var paymentApiUrl = '/api/v1/';
	var managePaymentApi = {};
	
	managePaymentApi.list = function(search, table) {
		return $http({
			method : Constants.METHOD_GET
			, url  : paymentApiUrl + 'invoice?client_id=' + search.client_id
				+ '&order_no=' + search.order_no
				+ '&subscription_name=' + search.subscription_name
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	managePaymentApi.listSubscription =function() {
		return $http({
			method : Constants.METHOD_GET
			, url  : paymentApiUrl + 'subscription'
		});
	}

	return managePaymentApi;
}