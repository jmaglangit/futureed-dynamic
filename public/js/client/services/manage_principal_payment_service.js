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

	managePaymentApi.subscriptionDetails =function(id) {
		return $http({
			method : Constants.METHOD_GET
			, url  : paymentApiUrl + 'subscription/' + id
		});
	}

	managePaymentApi.listClassrooms = function(search, table) {
		return $http({
			method : Constants.METHOD_GET
			, url  : paymentApiUrl + 'classroom?order_no=' + search.order_no
		});
	}

	managePaymentApi.addPayment = function(data) {
		return $http({
			method : Constants.METHOD_POST
			, data : data
			, url  : paymentApiUrl + 'invoice'
		});
	}

	managePaymentApi.addClassroom = function(data) {
		return $http({
			method : Constants.METHOD_POST
			, data : data
			, url  : paymentApiUrl + 'classroom'
		});
	}

	managePaymentApi.getInvoiceNo = function(id) {
		return $http({
			method : Constants.METHOD_GET
			, url  : paymentApiUrl + 'invoice/get-next-invoice-no/' + id
		});
	}

	managePaymentApi.getOrderNo = function(id) {
		return $http({
			method : Constants.METHOD_GET
			, url  : paymentApiUrl + 'order/get-next-order-no/' + id
		});
	}

	managePaymentApi.getClientDiscount = function(id) {
		return $http({
			method : Constants.METHOD_GET
			, url  : paymentApiUrl + 'invoice/client-invoice-discount/' + id
		});
	}

	managePaymentApi.getBulkDiscount = function(min_seats) {
		return $http({
			method : Constants.METHOD_GET
			, url  : paymentApiUrl + 'volume-discount/rounded-off-discount/' + min_seats
		});
	}

	managePaymentApi.getTeacherDetails = function(search) {
		return $http({
			method : Constants.METHOD_GET
			, url  : paymentApiUrl + 'client/custom/view-details?'
				+ "school_code=" + search.school_code
				+ "&client_role=" + search.client_role
				+ "&name=" + search.client_name
		});
	}

	managePaymentApi.cancelPayment = function(order_no) {
		return $http({
			method : Constants.METHOD_DELETE
			, url  : paymentApiUrl + 'classroom/delete-classroom-by-order-no/' + order_no
		});
	}

	return managePaymentApi;
}