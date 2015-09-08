angular.module('futureed.services')
	.factory('ManageParentPaymentService', ManageParentPaymentService);

function ManageParentPaymentService($http){
	var serviceUrl = '/api/v1/';
	var service = {};
	
	service.list = function(search, table) {
		return $http({
			method : Constants.METHOD_GET
			, url  : serviceUrl + 'invoice?client_id=' + search.client_id
				+ '&order_no=' + search.order_no
				+ '&subscription_name=' + search.subscription_name
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	service.viewPayment = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'invoice/' + id
		})
	}

	service.getSubscriptionList = function() {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'subscription'
		})
	}

	service.getClient = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'client/' + id
		})
	}

	service.getStudents = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'order-detail/get-students/' + id
		})
	}

	service.getClientDiscount = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'invoice/client-invoice-discount/' + id
		})
	}

	service.getBulkDiscount = function(min_seats) {
		return $http({
			method : Constants.METHOD_GET
			, url  : serviceUrl + 'volume-discount/rounded-off-discount/' + min_seats
		});
	}

	service.getOrderNo = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'order/get-next-order-no/' + id
		})
	}

	service.addInvoice = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: serviceUrl + 'invoice'
		})
	}

	service.addStudentOrderByEmail = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: serviceUrl + 'parent-student/add-students-by-email'
		})
	}

	service.searchName = function(name, id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'client/manage/student?client_id=' + id
					+ '&name=' + name
		});
	}

	service.deleteInvoice = function(id) {
		return $http({
			method 	: Constants.METHOD_DELETE
			, url 	: serviceUrl + 'invoice/' + id
		});
	}

	service.addStudentOrderByUsername = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: serviceUrl + 'parent-student/add-students-by-username'
		})
	}

	service.paySubscription = function(data) {
		return $http({
			method : Constants.METHOD_PUT
			, data : data
			, url  : serviceUrl + 'parent-student/pay-subscription/' + data.id
		});
	}

	service.getPaymentUri = function(data) {
		return $http({
			method : Constants.METHOD_POST
			, data : data
			, url  : serviceUrl + 'payment'
		});
	}

	service.removeStudent = function(id) {
		return $http({
			method : Constants.METHOD_DELETE
			, url  : serviceUrl + 'order-detail/' + id
		});
	}

	service.cancelInvoice = function(id) {
		return $http({
			method : Constants.METHOD_PUT
			, url  : serviceUrl + 'invoice/cancel-invoice/' + id
		});
	}

	service.getSubject = function() {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'subject'
		});
	}
	return service;
}