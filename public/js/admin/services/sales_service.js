angular.module('futureed.services')
	.factory('salesService', salesService);

function salesService($http){
	var salesAPI = {}
	var salesApiUrl = '/api/v1/';

	salesAPI.addPrice = addPrice;
	salesAPI.getPriceList = getPriceList;
	salesAPI.deletePrice = deletePrice;
	salesAPI.getPrice = getPrice;
	salesAPI.editPrice = editPrice;

	salesAPI.getDiscountList = getDiscountList;
	salesAPI.addClientDiscount = addClientDiscount;
	salesAPI.getDiscountDetails = getDiscountDetails;
	salesAPI.updateClientDiscount = updateClientDiscount
	salesAPI.deleteClientDiscount = deleteClientDiscount;
	salesAPI.suggestClient = suggestClient;

	salesAPI.addBulk = addBulk;
	salesAPI.getBulkList = getBulkList;
	salesAPI.getBulk = getBulk;
	salesAPI.editBulk = editBulk;
	salesAPI.deleteBulk = deleteBulk;

	/**
	* Add Price API
	* @return ID
	*/
	function addPrice(data){
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

	function getPriceList(){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: salesApiUrl + 'subscription'
		});
	}

	function deletePrice(id){
		return $http({
			method 	: Constants.METHOD_DELETE
			, url 	: salesApiUrl + 'subscription/' + id
		});
	}

	function getPrice(id){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: salesApiUrl + 'subscription/' + id
		});
	}

	function editPrice(data){
		return $http({
			method 	: Constants.METHOD_PUT
			, data 	: data
			, url 	: salesApiUrl + 'subscription/' + data.id
		});
	}

	function addBulk(seats,percentage,status){
		return $http({
			method 	: Constants.METHOD_POST
			, data  : {min_seats : seats, percentage : percentage, status : status}
			, url 	: salesApiUrl + 'volume-discount'
		});
	}

	/**
	* Client Discounts
	*/
	function getDiscountList(data) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: salesApiUrl + 'client-discount'
		});
	}

	function addClientDiscount(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data  : data
			, url 	: salesApiUrl + 'client-discount'
		});
	}

	function getDiscountDetails(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: salesApiUrl + 'client-discount/' + id
		});
	}

	function updateClientDiscount(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data 	: data
			, url 	: salesApiUrl + 'client-discount/' + data.id
		});
	}

	function deleteClientDiscount(id) {
		return $http({
			method 	: Constants.METHOD_DELETE
			, url 	: salesApiUrl + 'client-discount/' + id
		});
	}

	function suggestClient(name) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: salesApiUrl + 'client/custom/view-details?name=' + name
		});
	}

	/**
	* Bulk Settings
	*/
	function getBulkList(){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: salesApiUrl + 'volume-discount'
		})
	}

	function getBulk(id){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: salesApiUrl + 'volume-discount/' + id
		});
	}

	function editBulk(data){
		return $http({
			method 	: Constants.METHOD_PUT
			, data 	: data 
			, url 	: salesApiUrl + 'volume-discount/' + data.id
		})
	}

	function deleteBulk(id){
		return $http({
			method 	: Constants.METHOD_DELETE
			, url 	: salesApiUrl + 'volume-discount/' + id
		});
	}
	return salesAPI;
}