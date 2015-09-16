angular.module('futureed.services')
	.factory('ManageInvoiceService', ManageInvoiceService);

function ManageInvoiceService($http) {
	var serviceUrl = '/api/v1/';
	var service = {}

	service.list = function(search, table) {
		return $http({
			method : Constants.METHOD_GET
			, url  : serviceUrl + 'invoice?order_no=' + search.order_no
				+ '&subscription_name=' + search.subscription_name
				+ '&payment_status=' + search.payment_status
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	service.details = function(invoice_no) {
		return $http({
			method : Constants.METHOD_GET
			, url  : serviceUrl + 'sales-invoice/details?id=' + invoice_no
		});
	}

	service.updateStatus = function(data) {
		return $http({
			method : Constants.METHOD_POST
			, data : data
			, url  : serviceUrl + 'sales-invoice/edit'
		});
	}

	service.viewAllStudents = function(id) {
		return $http({
			method : Constants.METHOD_GET
			, url  : serviceUrl + 'invoice/' + id
		});
	}

	service.getSubscriptionList = function() {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'subscription'
		})
	}

	return service
}