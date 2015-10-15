angular.module('futureed.controllers')
	.controller('SalesController', SalesController);

SalesController.$inject = ['$scope','salesService', 'TableService'];

function SalesController($scope, salesService, TableService) {

	var self 			= this;

	TableService(self);
	self.tableDefaults();

	self.price 			= [{}];
	self.data			= {};
	self.delete 		= {};
	self.validation		= {};

	self.getDiscountList = getDiscountList;
	self.addClientDiscount = addClientDiscount;
	self.getDiscountDetails = getDiscountDetails;
	self.updateClientDiscount = updateClientDiscount
	self.confirmDeleteSubject = confirmDeleteSubject;
	self.deleteClientDiscount = deleteClientDiscount;
	self.suggestClient = suggestClient;
	self.selectClient = selectClient;

	self.addBulk		= addBulk;
	self.getBulkList	= getBulkList;
	self.getBulk 		= getBulk;
	self.editBulk 		= editBulk;
	self.deleteBulk 	= deleteBulk;

	self.setActive = function(active) {
		self.errors = Constants.FALSE;

		self.active_price_settings = Constants.FALSE;
		self.active_client_discount = Constants.FALSE;
		self.active_bulk_settings = Constants.FALSE;

		switch(active) {
			case 'bulk_settings':
				self.active_bulk_settings = Constants.TRUE;
				break;

			case 'client_discount':
				self.active_client_discount = Constants.TRUE;
				break;

			case 'price_settings':
			default:
				self.active_price_settings = Constants.TRUE;
				break;
		}
	}

	/**
	* Get Price List
	*/

	self.list = function() {
		if(self.active_price_settings_list) {
			self.getPriceList();
		} else if(self.active_client_discount_list) {
			self.getDiscountList();
		} else if(self.active_bulk_settings_list) {
			self.getBulkList();
		}
	}

	/**
	* Client Discounts
	*/
	function getDiscountList() {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		salesService.getDiscountList(self.table).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if (response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.discounts = response.data.records;
					self.updatePageCount(response.data);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	function addClientDiscount() {
		self.errors = Constants.FALSE;
		self.clients = Constants.FALSE;

		$("#add_discount_form input").removeClass("required-field");

		$scope.ui_block();
		salesService.addClientDiscount(self.data).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if (response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key){
						$("#add_discount_form input[name='" + value.field +"']" ).addClass("required-field");

						if(angular.equals(value.field, 'client_id')) {
							$("#discount_form input[name='name']").addClass("required-field");
						}
					});
				} else if(response.data) {
					self.data = {};
					self.data.is_success = Constants.ADD_DISCOUNT_SUCCESS;
					self.setDiscountsActive('client_discount_list');
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	function getDiscountDetails(id) {
		self.errors = Constants.FALSE;
		self.data = {};

		$scope.ui_block();		
		salesService.getDiscountDetails(id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler();
				} else if(response.data) {
					self.data.id 			= response.data.id;
					self.data.client_id 	= response.data.client_id;
					self.data.name 			= response.data.client.user.name;
					self.data.email 		= response.data.client.user.email;
					self.data.percentage 	= response.data.percentage;
					self.data.status 		= response.data.status;

					self.setDiscountsActive('client_discount_edit');
				}
			}

			$scope.ui_unblock();		
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();		
		});
	}

	function updateClientDiscount() {
		self.errors = Constants.FALSE;
		$('input').removeClass('required-field');

		$scope.ui_block();
		salesService.updateClientDiscount(self.data).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key){
						$("#discount_form input[name='" + value.field +"']").addClass("required-field");
					});
				}else if(response.data){
					self.data = {};
					self.data.is_success = Constants.EDIT_DISCOUNT_SUCCESS;
					self.setDiscountsActive('client_discount_list');
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.internalError();
			$scope.ui_unblock();
		});
	}

	function confirmDeleteSubject(id) {
		self.errors = Constants.FALSE;

		self.delete.id = id;
		self.delete.confirm = Constants.TRUE;
		$("#delete_discount_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	function deleteClientDiscount(id) {
		self.errors = Constants.FALSE;
		self.data = {};

		$scope.ui_block();
		salesService.deleteClientDiscount(id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.data){
					if(response.data == Constants.STATUS_FALSE){
						self.errors = Constants.DELETE_ERROR;
					}else{
						self.data.is_success = Constants.DELETE_DISCOUNT_SUCCESS;
						self.setDiscountsActive('client_discount_list');
					}
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.internalError();
			$scope.ui_unblock();
		});
	}

	function suggestClient() {
		self.errors = Constants.FALSE;
		self.clients = Constants.FALSE;

		self.validation.c_error = Constants.FALSE;
		self.validation.c_loading = Constants.TRUE;

		self.data.client_id = Constants.EMPTY_STR;
		self.data.email = Constants.EMPTY_STR;

		salesService.suggestClient(self.data.name).success(function(response) {
			self.validation.c_loading = Constants.FALSE;
			
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if (response.errors) {
					self.validation.c_error = response.errors[0].message;
				} else if(response.data) {
					if(response.data.length > 0) {
						self.clients = response.data;
					} else {
						self.validation.c_error = "Client does not exist.";
					}
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			self.validation.c_loading = Constants.FALSE;
		});
	}

	function selectClient(client) {
		self.data.client_id = client.id;
		self.data.email = client.email;
		self.data.name = client.first_name + " " + client.last_name;

		self.clients = Constants.FALSE;
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
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	/**
	* get Bulk Discount list
	*/
	function getBulkList(){
		self.errors = Constants.FALSE;

		$scope.ui_block();
		salesService.getBulkList(self.table).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.bulk = response.data.records;
					self.updatePageCount(response.data);
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
			self.errors = $scope.internalError();
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
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
}