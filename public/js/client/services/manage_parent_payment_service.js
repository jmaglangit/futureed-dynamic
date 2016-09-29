angular.module('futureed.services')
	.factory('ManageParentPaymentService', ManageParentPaymentService);

function ManageParentPaymentService($http){
	var serviceUrl = '/api/v1/';
	var service = {};

	service.checkBillingAddress = function(id) {
		return $http({
			method : Constants.METHOD_GET,
			 url   : serviceUrl + 'client/check-billing-address/' + id
		});
	}

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
			, url  : serviceUrl + 'parent-student/pay-subscription'
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
			, url 	: serviceUrl + 'subject?status=Enabled'
		});
	}

	service.renewSubscription = function(data) {
		return $http({
			method	: Constants.METHOD_POST
			, data	: data
			, url	: serviceUrl + 'renew-subscription/' + data.invoice_id
		});
	}

	service.subscriptionPackages = function(data) {
		return $http({
			method	:	Constants.METHOD_GET
			, url	:	serviceUrl + 'subscription-package?'
			+ 'subject_id=' + ((data.subject_id) ? data.subject_id : '')
			+ '&days_id=' + ((data.days_id) ? data.days_id : '')
			+ '&subscription_id=' + ((data.subscription_id) ? data.subscription_id : '')
			+ '&country_id=' + ((data.country_id) ? data.country_id : '')
			+ '&status=' + Constants.ENABLED
		});
	}

	service.getCountry = function(id){
		return $http({
			method	:	Constants.METHOD_GET
			, url	:	serviceUrl + 'countries/' + id
		});
	}

	service.getCountryList = function(){
		return $http({
			method	:	Constants.METHOD_GET
			, url	:	serviceUrl + 'countries'
		});
	}

	service.getClientSubscriptionDiscount = function(user_id){

		return $http({
			method	: Constants.METHOD_GET
			, url	: serviceUrl + 'client-discount?'
			+ 'user_id=' + ((user_id) ? user_id : '')
		});
	}

	// /api/v1/client/manage/student?client_id={id of client}&name=&email=&limit=&offset=0
	service.listStudents = function(client_id, data){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'client/manage/student?client_id=' + client_id
				+ '&name=' + ((data.name) ?  data.name : '')
				+ '&email=' + ((data.email) ? data.email : '')
				+ '&offset=' + ((data.offset) ? data.offset : '')
		});
	}

	//api/v1/client/update-billing-address/{id}
	service.updateBillingAddress = function(data){
		return $http({
			method	: Constants.METHOD_POST
			, data	: data
			, url	: serviceUrl + 'client/update-billing-address/' + data.id
		});
	}

	//service.subs  api/v1/subscription-package/{id}
	service.subscriptionPackage = function(id){
		return $http({
			method	:	Constants.METHOD_GET
			, url	:	serviceUrl + 'subscription-package/' + id
		});
	}

	service.updateOrder = function(order_id,data){
		return $http({
			method	: Constants.METHOD_PUT
			, data	: data
			, url	: serviceUrl + 'order/' + order_id
		});
	}

	service.getOrder = function(order_id){
		return $http({
			method	: Constants.METHOD_GET
			, url	: serviceUrl + 'order/' + order_id
		});
	}

	//get curriculum country
	service.getCurriculumCountry = function($user_id){
		return $http({
			method	:	Constants.METHOD_GET,
			url		:	serviceUrl +'user/curriculum-country/' + $user_id
		});
	}

	return service;
}