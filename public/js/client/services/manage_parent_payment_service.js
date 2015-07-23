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
			, url 	: paymentApiUrl + 'order-detail/get-students/' + id
		})
	}

	managePaymentApi.getClientDiscount = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: paymentApiUrl + 'invoice/client-invoice-discount/' + id
		})
	}

	managePaymentApi.getOrderNo = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: paymentApiUrl + 'order/get-next-order-no/' + id
		})
	}

	managePaymentApi.addInvoice = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: paymentApiUrl + 'invoice'
		})
	}

	managePaymentApi.addStudentOrderByEmail = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, url 	: paymentApiUrl + 'parent-student/add-students-by-email?email=' + data.email
				+ '&parent_id=' + data.parent_id
				+ '&order_id=' + data.order_id
				+ '&price=' + data.price
		})
	}

	managePaymentApi.searchName = function(name, id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: paymentApiUrl + 'client/manage/student?client_id=' + id
					+ '&name=' + name
		});
	}

	managePaymentApi.deleteInvoice = function(id) {
		return $http({
			method 	: Constants.METHOD_DELETE
			, url 	: paymentApiUrl + 'invoice/' + id
		});
	}

	managePaymentApi.addStudentOrderByUsername = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, url 	: paymentApiUrl + 'parent-student/add-students-by-username?username=' + data.username
				+ '&parent_id=' + data.parent_id
				+ '&order_id=' + data.order_id
				+ '&price=' + data.price
		})
	}

	managePaymentApi.paySubscription = function(data) {
		return $http({
			method : Constants.METHOD_PUT
			, data : data
			, url  : paymentApiUrl + 'parent-student/pay-subscription/' + data.id
		});
	}

	managePaymentApi.getPaymentUri = function(data) {
		return $http({
			method : Constants.METHOD_POST
			, data : data
			, url  : paymentApiUrl + 'payment'
		});
	}

	managePaymentApi.removeStudent = function(id) {
		return $http({
			method : Constants.METHOD_DELETE
			, url  : paymentApiUrl + 'order-detail/' + id
		});
	}

	managePaymentApi.cancelInvoice = function(id) {
		return $http({
			method : Constants.METHOD_PUT
			, url  : paymentApiUrl + 'invoice/cancel-invoice/' + id
		});
	}
	return managePaymentApi;
}