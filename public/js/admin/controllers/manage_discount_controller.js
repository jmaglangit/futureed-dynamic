angular.module('futureed.controllers')
	.controller('ManageDiscountController', ManageDiscountController);

ManageDiscountController.$inject = ['$scope','salesService', 'TableService'];

function ManageDiscountController($scope, salesService, TableService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.record = {};
		self.validation = {};
		self.fields = [];

		self.tableDefaults();

		self.active_list = Constants.TRUE;
		self.active_add = Constants.FALSE;
		self.active_edit = Constants.FALSE;

		switch(active) {
			case	Constants.ACTIVE_ADD	:
				self.active_add = Constants.TRUE;
				break;

			case	Constants.ACTIVE_EDIT 	:
				self.active_edit = Constants.TRUE;
				self.details(id);
				break;
					
			case	Constants.ACTIVE_LIST 	:
			default	:
				self.active_list = Constants.TRUE;
				self.list();
				break;
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.list = function() {
		self.errors = Constants.FALSE;

		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		salesService.getDiscountList(self.table).success(function(response) {
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if (response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.records = response.data.records;
					self.updatePageCount(response.data);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			self.table.loading = Constants.FALSE;
			$scope.ui_unblock();
		});
	}

	self.add = function() {
		self.errors = Constants.FALSE;
		self.clients = Constants.FALSE;

		self.fields = [];

		$scope.ui_block();
		salesService.addClientDiscount(self.record).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if (response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key){
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.setActive();
					self.setActive(Constants.ACTIVE_ADD);
					self.success = Constants.MSG_CREATED("Client discount");
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.details = function(id) {
		self.errors = Constants.FALSE;

		$scope.ui_block();		
		salesService.getDiscountDetails(id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler();
				} else if(response.data) {
					self.record.id 			= response.data.id;
					self.record.client_id 	= response.data.client_id;
					self.record.name 		= response.data.client.user.name;
					self.record.email 		= response.data.client.user.email;
					self.record.percentage 	= response.data.percentage;
					self.record.status 		= response.data.status;
				}
			}

			$scope.ui_unblock();		
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();		
		});
	}

	self.update = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.fields = [];

		$scope.ui_block();
		salesService.updateClientDiscount(self.record).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key){
						self.fields[value.field] = Constants.TRUE;
					});
				}else if(response.data){
					var id = self.record.id;

					self.setActive();
					self.setActive(Constants.ACTIVE_EDIT, id);
					self.success = Constants.MSG_UPDATED("Client discount");
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.deleteClientDiscount = function(id) {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		salesService.deleteClientDiscount(id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data) {
					self.setActive();
					self.success = Constants.MSG_DELETED("Client discount");
				}
			}

			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.suggestClient = function() {
		self.errors = Constants.FALSE;
		self.clients = Constants.FALSE;

		self.validation.c_error = Constants.FALSE;
		self.validation.c_loading = Constants.TRUE;

		self.record.client_id = Constants.EMPTY_STR;
		self.record.email = Constants.EMPTY_STR;

		salesService.suggestClient(self.record.name).success(function(response) {
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

	self.selectClient = function(client) {
		self.record.client_id = client.id;
		self.record.email = client.email;
		self.record.name = client.first_name + " " + client.last_name;

		self.clients = Constants.FALSE;
	}
}