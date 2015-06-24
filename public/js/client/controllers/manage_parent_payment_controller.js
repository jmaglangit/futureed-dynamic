angular.module('futureed.controllers')
	.controller('ManageParentPaymentController', ManageParentPaymentController);

ManageParentPaymentController.$inject = ['$scope','$window', '$filter', 'ManageParentPaymentService', 'apiService', 'TableService', 'SearchService'];

function ManageParentPaymentController($scope, $window, $filter, ManageParentPaymentService, apiService, TableService, SearchService) {
	var self = this;
	
	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.students = {};
	self.invoice = {};
	self.user_id = $scope.user.id;

	self.setActive = function(active, id, cond)
	{
		self.errors = Constants.FALSE;
		self.cond = (cond) ? 1:0;
		self.getClientDiscount(self.user_id);

		if(self.cond == 0){
			self.success = Constants.FALSE;
		}
		switch(active){
			case Constants.ACTIVE_ADD:
				self.active_add = Constants.TRUE;
				self.active_list = Constants.FALSE;
				self.active_view = Constants.FALSE;
				break;

			case Constants.ACTIVE_VIEW:
				self.active_add = Constants.FALSE;
				self.active_list = Constants.FALSE;
				self.active_view = Constants.TRUE;
				self.getSubscriptionList();
				self.getClient(self.user_id);
				self.viewPayment(id, self.cond);
				break;

			case Constants.ACTIVE_LIST:
			default:
			self.active_list = Constants.TRUE;
			self.active_add = Constants.FALSE;
			self.active_view = Constants.FALSE
			break;
		}

	$("html, body").animate({ scrollTop: 0 }, "slow");
	
	}

	self.list = function() {
		if(self.active_list) {
			self.listPayments();
		} else if(self.active_add) {
			self.listClassroom();
		}
	}

	self.searchFnc = function(event) {
		self.listPayments();
		event = getEvent(event);
		event.preventDefault();
	}

	self.clear = function() {
		self.searchDefaults();
		self.listPayments();
	}

	self.listPayments = function() {
		self.errors = Constants.FALSE;
		self.search.client_id = $scope.user.id;
		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		ManageParentPaymentService.list(self.search, self.table).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
					self.table.loading = Constants.FALSE;
				} else if(response.data) {
					self.table.loading = Constants.FALSE;
					self.records = response.data.records;
					self.updatePageCount(response.data);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.viewPayment = function(id, cond) {
		self.errors = Constants.FALSE;

		$scope.ui_block();

		ManageParentPaymentService.viewPayment(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.invoice = response.data;
					var subscription_id = self.invoice.subscription.id;
					self.getSubscription(subscription_id);

					if(self.discount != null) {
						self.invoice.discount = self.discount.percentage;
					}else{
						self.invoice.discount = 0;
					}
					self.invoice.subtotal = self.subtotal;
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.getSubscriptionList = function() {
		self.errors = Constants.FALSE;
		self.subscriptions = [];
		ManageParentPaymentService.getSubscriptionList().success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.subscriptions = response.data.records;
				}
			}
		}).error(function(response){
			self.errors = $scope.internalError();
		});
	}

	self.getClient = function(id) {
		self.errors = Constants.FALSE;
		self.client = {};

		ManageParentPaymentService.getClient(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.client = response.data;
				}
			}
		}).error(function(response){
			self.errors = $scope.internalError();
		});
	}

	//get Students associated to the payment
	self.getStudents = function(id) {
		self.errors = Constants.FALSE;
		var id = $scope.user.id;

		ManageParentPaymentService.getStudents(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.students = response.data;
					self.students.price = self.subscription.price;

					self.subtotal = 0.00;
					for(var i = 0; i < self.students.length; i++){
				        self.subtotal = self.subtotal + parseInt(self.students.price);
				    }

				    self.invoice.subtotal = self.subtotal + '.00';
				    self.invoice.total = (self.invoice.discount != 0) ? (self.subtotal * (parseInt(self.invoice.discount)/100)) : self.invoice.subtotal;
				}
			}
		}).error(function(response){
			self.errors = $scope.internalError();
		});
	}

	self.getSubscription = function(id) {
		self.errors = Constants.FALSE;

		ManageParentPaymentService.getSubscription(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.subscription = response.data;
					self.getStudents();
				}
			}
		}).error(function(response){
			self.errors = $scope.internalError();
		});
	}

	self.getClientDiscount = function(id){
		self.errors = Constants.FALSE;

		ManageParentPaymentService.getClientDiscount(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					angular.forEach(response.data, function(value, key){
						self.discount = value;
					});
				}
			}
		}).error(function(response){
			self.errors = $scope.internalError();
		});
	}

}