angular.module('futureed.controllers')
	.controller('SalesController', SalesController);

SalesController.$inject = ['$scope','salesService'];

function SalesController($scope, salesService) {

	var self 			= this;

	self.price 			= [{}];
	self.data			= {};

	self.setDiscountsActive = setDiscountsActive;

	self.addPrice 		= addPrice;
	self.getPriceList 	= getPriceList;
	self.deletePrice 	= deletePrice;
	self.editPrice 		= editPrice;
	self.getPrice 		= getPrice;
	self.addBulk		= addBulk;
	self.getBulkList	= getBulkList;
	self.getBulk 		= getBulk;
	self.editBulk 		= editBulk;
	self.deleteBulk 	= deleteBulk;

	self.selectTab		= selectTab;

	function selectTab(active) {
		self.data.is_success = Constants.FALSE;

		switch(active) {
			case	'client_discount_list' :
				self.setDiscountsActive('client_discount_list');
				break;

			case	'bulk_settings_list' :
				self.setDiscountsActive('bulk_settings_list');
				break;
					
			case	'price_settings_list' :
			default	:
				self.setDiscountsActive('price_settings_list');
				break;
		}
	}

	function setDiscountsActive(active) {
		self.errors = Constants.FALSE;

		self.active_price_settings_list = Constants.FALSE;
		self.active_price_settings_add = Constants.FALSE;
		self.active_price_settings_edit = Constants.FALSE;

		self.active_client_discount_list = Constants.FALSE;
		self.active_client_discount_add = Constants.FALSE;
		self.active_client_discount_edit = Constants.FALSE;

		self.active_bulk_settings_list = Constants.FALSE;
		self.active_bulk_settings_add = Constants.FALSE;
		self.active_bulk_settings_edit = Constants.FALSE;

		switch(active) {
			case	'price_settings_add' :
				self.data = {};
				self.active_price_settings_add = Constants.TRUE;
				self.active_price_settings_list = Constants.TRUE;
				break;

			case	'price_settings_edit' :
				self.active_price_settings_edit = Constants.TRUE;
				self.active_price_settings_list = Constants.TRUE;
				break;

			case	'client_discount_list' :
				self.active_client_discount_list = Constants.TRUE;
				break;

			case	'client_discount_add' :
				self.data = {};
				self.active_client_discount_add = Constants.TRUE;
				self.active_client_discount_list = Constants.TRUE;
				break;

			case	'client_discount_edit' :
				self.active_client_discount_edit = Constants.TRUE;
				self.active_client_discount_list = Constants.TRUE;
				break;

			case	'bulk_settings_list' :
				self.getBulkList();
				self.active_bulk_settings_list = Constants.TRUE;
				break;

			case	'bulk_settings_add' :
				self.data = {};
				self.active_bulk_settings_add = Constants.TRUE;
				self.active_bulk_settings_list = Constants.TRUE;
				break;

			case	'bulk_settings_edit' :
				self.active_bulk_settings_edit = Constants.TRUE;
				self.active_bulk_settings_list = Constants.TRUE;
				break;
					
			case	'price_settings_list' :
			default	:
				self.getPriceList();
				self.active_price_settings_list = Constants.TRUE;
				break;
		}

		$("input, textarea, select").removeClass("required-field");
		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	/**
	* Get Price List
	*/
	function getPriceList(){
		salesService.getPriceList().success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.price = response.data.records
				}
			}
		}).error(function(response){
			self.errors = $scope.internalError();
		});
	}

	/**
	* Add price
	*/
	function addPrice(){
		self.errors = Constants.FALSE;

		$("input, textarea").removeClass("required-field");

		$scope.ui_block();
		salesService.addPrice(self.data).success(function(response){
			if(response.status == Constants.STATUS_OK){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key){
						$("#price_form input[name='" + value.field +"']" ).addClass("required-field");
						$("#price_form textarea[name='" + value.field +"']" ).addClass("required-field");
					});
				}else if(response.data){
					self.data = {};
					self.data.is_success = Constants.ADD_PRICE_SUCCESS;
					self.setDiscountsActive('price_settings_list');
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			$scope.ui_unblock();
			self.errors = $scope.internalError();
		});
	}

	/**
	* get Price
	*/
	function getPrice(id){
		self.errors = Constants.FALSE;
		self.data = {};

		$scope.ui_block();		
		salesService.getPrice(id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.data){
					self.data = response.data;
					self.setDiscountsActive('price_settings_edit');
				}
			}

			$scope.ui_unblock();		
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();		
		});
	}

	/**
	* edit Price
	*/
	function editPrice(){
		this.errors = Constants.FALSE;
		$('input, select').removeClass('required-field');

		$scope.ui_block();

		salesService.editPrice(this.data).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key){
						$("#price_form input[name='" + value.field +"']" ).addClass("required-field");
					});
				}else if(response.data) {
					self.data = {};
					self.data.is_success = Constants.EDIT_PRICE_SUCCESS;
					self.setDiscountsActive('price_settings_list');
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			$scope.ui_unblock();
			this.errors = $scope.internalError();
		});
	}

	/**
	* Delete Price
	*/
	function deletePrice(id){
		self.errors = Constants.FALSE;
		self.data = {};

		$scope.ui_block();
		salesService.deletePrice(id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.data){
					if(response.data == Constants.STATUS_FALSE){
						self.errors = Constants.DELETE_ERROR;
					}else{
						self.data.is_success = Constants.DELETE_PRICE_SUCCESS;
						self.setDiscountsActive('price_settings_list');
					}
				}
			}

			$scope.ui_unblock();
		}).error(function(response){
			$scope.ui_unblock();
			self.errors = $scope.internalError();
		});
	}

	/**
	* Add Bulk Discount
	*/
	function addBulk(){
		self.errors = Constants.FALSE;
		$('input').removeClass('required-field');

		$scope.ui_block();
		salesService.addBulk(self.data.min_seats, self.data.percentage, self.data.status).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key){
						$("#bulk-form input[name='" + value.field +"']").addClass("required-field");
					});
				}else if(response.data){
					self.data = {};
					self.data.is_success = Constants.ADD_BULK_SUCCESS;
					self.setDiscountsActive('bulk_settings_list');
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.internalError();
			$scope.ui_unblock();
		});
	}

	/**
	* get Bulk Discount list
	*/
	function getBulkList(){
		self.errors = Constants.FALSE;

		$scope.ui_block();
		salesService.getBulkList().success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.bulk = response.data.records;
				}
			}

			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	/**
	* get Bulk Discount 
	*/
	function getBulk(id){
		self.errors = Constants.FALSE;
		self.data = {};

		$scope.ui_block();
		salesService.getBulk(id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.data){
					self.data = response.data;
					self.setDiscountsActive('bulk_settings_edit');
				}
			}

			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	/**
	* get Bulk Discount 
	*/
	function editBulk(){
		self.errors = Constants.FALSE;
		$('input').removeClass('required-field');

		$scope.ui_block();
		salesService.editBulk(self.data).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key){
						$("#bulk-form input[name='" + value.field +"']").addClass("required-field");
					});
				}else if(response.data){
					self.data = {};
					self.data.is_success = Constants.EDIT_BULK_SUCCESS;
					self.setDiscountsActive('bulk_settings_list');
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.internalError();
			$scope.ui_unblock();
		});
	}

	/**
	* Delete Bulk Discount 
	*/
	function deleteBulk(id){
		self.errors = Constants.FALSE;
		self.data = {};

		$scope.ui_block();
		salesService.deleteBulk(id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.data){
					if(response.data == Constants.STATUS_FALSE){
						self.errors = Constants.DELETE_ERROR;
					}else{
						self.data.is_success = Constants.DELETE_BULK_SUCCESS;
						self.setDiscountsActive('bulk_settings_list');
					}
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.internalError();
			$scope.ui_unblock();
		});
	}
}