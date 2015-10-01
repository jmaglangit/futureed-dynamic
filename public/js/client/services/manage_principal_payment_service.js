angular.module('futureed.services')
	.factory('managePrincipalPaymentService', managePrincipalPaymentService);

function managePrincipalPaymentService($http){
	var apiUrl = '/api/v1/';
	var api = {};
	
	api.list = function(search, table) {
		return $http({
			method : Constants.METHOD_GET
			, url  : apiUrl + 'invoice?client_id=' + search.client_id
				+ '&order_no=' + search.order_no
				+ '&subscription_name=' + search.subscription_name
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	api.listSubscription =function() {
		return $http({
			method : Constants.METHOD_GET
			, url  : apiUrl + 'subscription'
		});
	}

	api.subscriptionDetails =function(id) {
		return $http({
			method : Constants.METHOD_GET
			, url  : apiUrl + 'subscription/' + id
		});
	}

	api.listClassrooms = function(search, table) {
		return $http({
			method : Constants.METHOD_GET
			, url  : apiUrl + 'classroom?order_no=' + search.order_no
		});
	}

	api.updatePayment = function(data) {
		return $http({
			method : Constants.METHOD_PUT
			, data : data
			, url  : apiUrl + 'invoice/' + data.id
		});
	}

	api.getPaymentUri = function(data) {
		return $http({
			method : Constants.METHOD_POST
			, data : data
			, url  : apiUrl + 'payment'
		});
	}

	api.addClassroom = function(data) {
		return $http({
			method : Constants.METHOD_POST
			, data : data
			, url  : apiUrl + 'classroom'
		});
	}

	api.addInvoice = function(data) {
		return $http({
			method : Constants.METHOD_POST
			, data : data
			, url  : apiUrl + 'invoice'
		});
	}

	api.getOrderNo = function(id) {
		return $http({
			method : Constants.METHOD_GET
			, url  : apiUrl + 'order/get-next-order-no/' + id
		});
	}

	api.getClientDiscount = function(id) {
		return $http({
			method : Constants.METHOD_GET
			, url  : apiUrl + 'invoice/client-invoice-discount/' + id
		});
	}

	api.getBulkDiscount = function(min_seats) {
		return $http({
			method : Constants.METHOD_GET
			, url  : apiUrl + 'volume-discount/rounded-off-discount/' + min_seats
		});
	}

	api.getTeacherDetails = function(search) {
		return $http({
			method : Constants.METHOD_GET
			, url  : apiUrl + 'client/custom/view-details?'
				+ "school_code=" + search.school_code
				+ "&client_role=" + search.client_role
				+ "&name=" + search.client_name
		});
	}

	api.cancelPayment = function(order_no) {
		return $http({
			method : Constants.METHOD_DELETE
			, url  : apiUrl + 'classroom/delete-classroom-by-order-no/' + order_no
		});
	}

	api.removeClassroom = function(id) {
		return $http({
			method : Constants.METHOD_DELETE
			, url  : apiUrl + 'classroom/' + id
		});
	}

	api.paymentDetails = function(id) {
		return $http({
			method : Constants.METHOD_GET
			, url  : apiUrl + 'invoice/' + id
		});
	}

	api.deleteInvoice = function(id) {
		return $http({
			method : Constants.METHOD_DELETE
			, url  : apiUrl + 'invoice/' + id
		});
	}

	api.cancelInvoice = function(id) {
		return $http({
			method : Constants.METHOD_PUT
			, url  : apiUrl + 'invoice/cancel-invoice/' + id
		});
	}

	api.getClassroom = function(id) {
		return $http({
			method : Constants.METHOD_GET
			, url  : apiUrl + 'classroom/' + id
		});
	}

	api.updateClassroom = function(data) {
		return $http({
			method : Constants.METHOD_PUT
			, data : data
			, url  : apiUrl + 'classroom/update-invoice-classroom/' + data.id
		});
	}

	api.getSubject = function() {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: apiUrl + 'subject?status=Enabled'
		});
	}

	api.renewSubscription = function(data) {
		return $http({
			method	: Constants.METHOD_POST
			, data	: data
			, url	: apiUrl + 'renew-subscription/' + data.invoice_id
		});
	}

	return api;
}