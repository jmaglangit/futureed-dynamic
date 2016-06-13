angular.module('futureed.services')
	.factory('salesService', salesService);

function salesService($http){
	var salesAPI = {}
	var salesApiUrl = '/api/v1/';

	/**
	* Subscription
	*/
	salesAPI.addPrice = function(data){
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: salesApiUrl + 'subscription'
		});
	}

	salesAPI.getPriceList = function(table){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: salesApiUrl + 'subscription?limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	salesAPI.deletePrice = function(id){
		return $http({
			method 	: Constants.METHOD_DELETE
			, url 	: salesApiUrl + 'subscription/' + id
		});
	}

	salesAPI.getPrice = function(id){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: salesApiUrl + 'subscription/' + id
		});
	}

	salesAPI.editPrice = function(data){
		return $http({
			method 	: Constants.METHOD_PUT
			, data 	: data
			, url 	: salesApiUrl + 'subscription/' + data.id
		});
	}

	salesAPI.addBulk = function(seats,percentage,status){
		return $http({
			method 	: Constants.METHOD_POST
			, data  : {min_seats : seats, percentage : percentage, status : status}
			, url 	: salesApiUrl + 'volume-discount'
		});
	}

	/**
	* Client Discounts
	*/
	salesAPI.getDiscountList = function(table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: salesApiUrl + 'client-discount?limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	salesAPI.addClientDiscount = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data  : data
			, url 	: salesApiUrl + 'client-discount'
		});
	}

	salesAPI.getDiscountDetails = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: salesApiUrl + 'client-discount/' + id
		});
	}

	salesAPI.updateClientDiscount = function(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data 	: data
			, url 	: salesApiUrl + 'client-discount/' + data.id
		});
	}

	salesAPI.deleteClientDiscount = function(id) {
		return $http({
			method 	: Constants.METHOD_DELETE
			, url 	: salesApiUrl + 'client-discount/' + id
		});
	}

	salesAPI.suggestClient = function(name) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: salesApiUrl + 'client/custom/view-details?name=' + name
				+ '&client_role=Parent,Principal'
		});
	}

	/**
	* Bulk Settings
	*/
	salesAPI.getBulkList = function(table){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: salesApiUrl + 'volume-discount?limit=' + table.size
				+ '&offset=' + table.offset
		})
	}

	salesAPI.getBulk = function(id){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: salesApiUrl + 'volume-discount/' + id
		});
	}

	salesAPI.editBulk = function(data){
		return $http({
			method 	: Constants.METHOD_PUT
			, data 	: data 
			, url 	: salesApiUrl + 'volume-discount/' + data.id
		})
	}

	salesAPI.deleteBulk = function(id){
		return $http({
			method 	: Constants.METHOD_DELETE
			, url 	: salesApiUrl + 'volume-discount/' + id
		});
	}

	/**
	 * Subscription Days
	 */
	//api/v1/subscription-day
	salesAPI.getSubscriptionDays = function(){
		return $http({
			method	: Constants.METHOD_GET
			, url	: salesApiUrl + 'subscription-day'
		});
	}

	// GET api/v1/subscription-day/{subscription_day}
	salesAPI.getSubscriptionDay = function(id){
		return $http({
			method	:	Constants.METHOD_GET
			, url	:	salesApiUrl + 'subscription-day/' + id
		});
	}

	salesAPI.addSubscriptionDay = function(data){
		return $http({
			method	:	Constants.METHOD_POST
			, data	:	data
			, url	: salesApiUrl + 'subscription-day'
		});
	}

	//PUT api/v1/subscription-day/{subscription_day}
	salesAPI.updateSubscriptionDay = function(data){
		return $http({
			method	:	Constants.METHOD_PUT
			, data	:	data
			, url	:	salesApiUrl + 'subscription-day/' + data.id
		});
	}

	//DELETE api/v1/subscription-day/{subscription_day}
	salesAPI.deleteSubscriptionDay = function(id){
		return $http({
			method	:	Constants.METHOD_DELETE
			, url	:	salesApiUrl + 'subscription-day/' + id
		});
	}

	return salesAPI;
}