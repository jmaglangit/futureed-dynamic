angular.module('futureed.services')
	.factory('ManageParentPaymentService', ManageParentPaymentService);

function ManageParentPaymentService($http){
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

	managePaymentApi.viewPayment = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: paymentApiUrl + 'invoice/' + id
		})
	}

	managePaymentApi.getSubscriptionList = function() {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: paymentApiUrl + 'subscription'
		})
	}

	managePaymentApi.getSubscription = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: paymentApiUrl + 'subscription/' + id
		})
	}

	managePaymentApi.getClient = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: paymentApiUrl + 'client/' + id
		})
	}

	managePaymentApi.getStudents = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: paymentApiUrl + 'parent-student/get-students/' + id
		})
	}

	managePaymentApi.getClientDiscount = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: paymentApiUrl + 'invoice/client-invoice-discount/' + id
		})
	}
	return managePaymentApi;
}