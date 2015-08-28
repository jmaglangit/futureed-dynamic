angular.module('futureed.services')
	.factory('StudentPaymentService', StudentPaymentService);

StudentPaymentService.$http = ['$http'];

function StudentPaymentService($http) {
	var service = {};
	var serviceUrl = '/api/v1/';

	service.list = function(search, table) {
		return $http({
			method : Constants.METHOD_GET
			, url  : serviceUrl + 'invoice?student_id=' + search.student_id
				+ '&order_no=' + search.order_no
				+ '&subscription_name=' + search.subscription_name
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	service.listSubscription =function() {
		return $http({
			method : Constants.METHOD_GET
			, url  : serviceUrl + 'subscription'
		});
	}

	service.add = function() {

	}

	service.getSubjects = function() {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'subject'
		});
	}

	service.subscriptionDetails =function(id) {
		return $http({
			method : Constants.METHOD_GET
			, url  : serviceUrl + 'subscription/' + id
		});
	}

	service.paySubscription = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: serviceUrl + 'student-payment'
		});
	}

	service.getPaymentUri = function(data) {
		return $http({
			method : Constants.METHOD_POST
			, data : data
			, url  : serviceUrl + 'payment'
		});
	}

	service.view = function() {

	}

	return service;
}