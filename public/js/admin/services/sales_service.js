angular.module('futureed.services')
	.factory('salesService', salesService);

function salesService($http){
	var salesAPI = {}
	var salesApiUrl = '/api/v1/';

	/**
	* Price Settings
	*/
	salesAPI.addPrice = function(data){
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: 
				{
					  name 			: data.name
					, price 		: data.price
					, description 	: data.description
					, status 		: data.status
				}
			, url 	: salesApiUrl + 'subscription'
		});
	}

	salesAPI.getPriceList = function(){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: salesApiUrl + 'subscription'
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
	salesAPI.getDiscountList = function(data) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: salesApiUrl + 'client-discount'
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
		});
	}

	/**
	* Bulk Settings
	*/
	salesAPI.getBulkList = function(){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: salesApiUrl + 'volume-discount'
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
	
	return salesAPI;
}