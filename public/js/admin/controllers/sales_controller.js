angular.module('futureed.controllers')
	.controller('SalesController', SalesController);

SalesController.$inject = ['$scope','salesService'];

function SalesController($scope, salesService) {

	var self 			= this;

	this.price 			= [{}];

	this.addPrice 		= addPrice;
	this.getPriceList 	= getPriceList;
	this.deletePrice 	= deletePrice;
	this.editPrice 		= editPrice;
	this.getPrice 		= getPrice;
	this.cancelEdit		= cancelEdit;
	this.addBulk		= addBulk;
	this.getBulkList	= getBulkList;
	this.getBulk 		= getBulk;
	this.editBulk 		= editBulk;
	this.deleteBulk 	= deleteBulk;

	/**
	* Add price
	*/
	function addPrice(){
		self.errors = Constants.FALSE;

		this.status = $('input[name=status]:checked', '#price_form').val();
		$scope.ui_block();

		salesService.addPrice(this.name, this.description, this.add_price, this.status).success(function(response){
			if(response.status == Constants.STATUS_OK){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key){
						$("#price_form input[name='" + value.field +"']" ).addClass("required-field");
					});
				}else if(response.data){
					self.is_success = Constants.PRICE_SUCCESS;
					self.getPriceList();
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			$scope.ui_unblock();
			self.errors = $scope.internalError();
		});
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
	* Delete Price
	*/
	function deletePrice(id){
		$scope.ui_block();

		salesService.deletePrice(id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.data){
					if(response.data == Constants.STATUS_FALSE){
						self.errors = Constants.DELETE_ERROR;
					}else{
						self.is_success = 'Price ' + Constants.DELETE_SUCCESS;
						self.getPriceList();
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
					self.is_success = 'Subscription ' + Constants.EDIT_SUCCESS;
					self.edit_price = Constants.FALSE;
					self.getPriceList();
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			$scope.ui_unblock();
			this.errors = $scope.internalError();
		});
			
	}

	/**
	* get Price
	*/
	function getPrice(id){
		self.is_success = Constants.FALSE;
		self.edit_price = Constants.TRUE;

		salesService.getPrice(id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.data){
					self.data = response.data;
				}
			}
		}).error(function(response){
			self.errors = internalError();			
		});
	}

	/**
	* Cancel edit Price
	*/
	function cancelEdit(req){
		
		switch(req){

			case 'price':
				self.edit_price = Constants.FALSE;
				break;

			case 'bulk':
			default:
				self.bulk_edit = Constants.FALSE;
				break;
		}
	}

	/**
	* Add Bulk Discount
	*/
	function addBulk(){
		self.errors = Constants.FALSE;
		$('input, select').removeClass('required-field');

		this.b_status = $('input[name=b_status]:checked', '#bulk-form').val();

		$scope.ui_block();
		salesService.addBulk(this.min_seats, this.percentage, this.b_status).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key){
						$("#bulk-form input[name='" + value.field +"']").addClass("required-field");
					});
				}else if(response.data){
					self.is_success = 'Bulk Discount ' + Constants.ADD_SUCCESS_MSG;
					self.getBulkList();
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

		salesService.getBulkList().success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.data){
					self.bulk = response.data.records;
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.internalError();
			$scope.ui_unblock();
		});
	}

	/**
	* get Bulk Discount 
	*/
	function getBulk(id){
		this.bulk_edit = Constants.TRUE;

		$scope.ui_block();
		salesService.getBulk(id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.data){
					self.data = response.data;
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.internalError();
			$scope.ui_unblock();
		})
	}

	/**
	* get Bulk Discount 
	*/
	function editBulk(){
		self.errors = Constants.FALSE;

		$scope.ui_block();
		salesService.editBulk(self.data).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key){
						$("#bulk-form input[name='" + value.field +"']").addClass("required-field");
					});
				}else if(response.data){
					self.is_success = 'Bulk Discount ' + Constants.EDIT_SUCCESS;
					self.bulk_edit = Constants.FALSE;
					self.getBulkList();
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.internalError();
			$scope.ui_unblock();
		})
	}

	/**
	* Delete Bulk Discount 
	*/
	function deleteBulk(id){
		self.is_success = Constants.FALSE;
		self.errors = Constants.FALSE;

		$scope.ui_block();
		salesService.deleteBulk(id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.data){
					self.is_success = 'Bulk Discount ' + Constants.DELETE_SUCCESS;
					self.bulk_edit = Constants.FALSE;
					self.getBulkList();
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.internalError();
			$scope.ui_unblock();
		})
	}
}