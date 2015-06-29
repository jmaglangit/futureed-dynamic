angular.module('futureed.services')
	.factory('manageInvoiceService', manageInvoiceService);

function manageInvoiceService($http) {
	var invoiceURL = '/api/v1/';
	var invoiceAPI = {}

	invoiceAPI.list = function(search, table) {
		return $http({
			method : Constants.METHOD_GET
			, url  : invoiceURL + 'invoice?order_no=' + search.order_no
				+ '&subscription_name=' + search.subscription_name
				+ '&payment_status=' + search.payment_status
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	invoiceAPI.details = function(invoice_no) {
		return $http({
			method : Constants.METHOD_GET
			, url  : invoiceURL + 'sales-invoice/details?id=' + invoice_no
		});
	}

	invoiceAPI.updateStatus = function(data) {
		return $http({
			method : Constants.METHOD_POST
			, data : data
			, url  : invoiceURL + 'sales-invoice/edit'
		});
	}

	return invoiceAPI
}