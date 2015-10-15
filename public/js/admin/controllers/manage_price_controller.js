angular.module('futureed.controllers')
	.controller('ManagePriceController', ManagePriceController);

ManagePriceController.$inject = ['$scope','salesService', 'TableService'];

function ManagePriceController($scope, salesService, TableService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.record = {};
		self.fields = [];

		self.tableDefaults();

		self.active_list = Constants.TRUE;
		self.active_add = Constants.FALSE;
		self.active_edit = Constants.FALSE;

		switch(active) {
			case	Constants.ACTIVE_ADD :
				self.active_add = Constants.TRUE;
				break;

			case	Constants.ACTIVE_EDIT :
				self.active_edit = Constants.TRUE;
				self.details(id);
				break;

			default	:
				self.active_list = Constants.TRUE;
				self.list();
				break;
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.list = function(){
		self.errors = Constants.FALSE;
		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		salesService.getPriceList(self.table).success(function(response){
			self.table.loading = Constants.TRUE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.records = response.data.records
					self.updatePageCount(response.data);
				}
			}

			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			self.table.loading = Constants.TRUE;
			$scope.ui_unblock();
		});
	}

	self.add = function(){
		self.errors = Constants.FALSE;
		self.fields = [];

		self.record.days = Math.abs(self.record.days);

		$scope.ui_block();
		salesService.addPrice(self.record).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key){
						self.fields[value.field] = Constants.TRUE;
					});
				}else if(response.data){
					self.setActive();
					self.setActive(Constants.ACTIVE_ADD);
					self.success = Constants.MSG_CREATED("Subscription");
				}
			}

			$scope.ui_unblock();
		}).error(function(response){
			$scope.ui_unblock();
			self.errors = $scope.internalError();
		});
	}

	self.details = function(id){
		self.errors = Constants.FALSE;

		$scope.ui_block();		
		salesService.getPrice(id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.record = response.data;
				}
			}
			
			$scope.ui_unblock();		
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();		
		});
	}

	self.update = function(){
		self.errors = Constants.FALSE;
		self.fields = [];

		self.record.days = Math.abs(self.record.days);

		$scope.ui_block();
		salesService.editPrice(self.record).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key){
						self.fields[value.field] = Constants.TRUE;
					});
				}else if(response.data) {
					var id = self.record.id;
					
					self.setActive();
					self.setActive(Constants.ACTIVE_EDIT, id);
					self.success = Constants.MSG_UPDATED("Subscription");
				}
			}

			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.deletePrice = function(id){
		self.errors = Constants.FALSE;

		$scope.ui_block();
		salesService.deletePrice(id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data) {
					self.setActive();
					self.success = Constants.MSG_DELETED("Subscription");
				}
			}

			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
}