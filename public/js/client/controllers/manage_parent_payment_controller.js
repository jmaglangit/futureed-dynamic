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
	self.create = {};
	self.search_name = {};
	self.validation = {};
	self.subscription = {};
	self.payment_total = {};
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
				self.date = {};
				self.add = {};
				self.active_add = Constants.TRUE;
				self.active_list = Constants.FALSE;
				self.active_view = Constants.FALSE;
				self.getSubscriptionList();
				self.getClient(self.user_id);
				break;

			case Constants.ACTIVE_VIEW:
				self.date = {};
				self.add = {};
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

	self.listPayments = function(frmdelete) {
		self.errors = Constants.FALSE;
		self.search.client_id = $scope.user.id;
		self.table.loading = Constants.TRUE;

		if(frmdelete != 1) {
			self.success = Constants.FALSE;
		}
		$scope.ui_block();
		ManageParentPaymentService.list(self.search, self.table).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
					self.table.loading = Constants.FALSE;
				} else if(response.data) {
					self.records = [];
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

					if(self.invoice.subscription){
						var subscription_id = self.invoice.subscription.id;
						self.getSubscription(subscription_id);
					}else{
						self.getStudents(self.invoice.order_no);
					}

					if(self.discount != null) {
						self.invoice.discount = self.discount.percentage;
					}else{
						self.invoice.discount = 0;
					}

					self.invoice.subtotal = self.subtotal;
					self.invoice.subscription_enable = (self.invoice.payment_status == Constants.PENDING) ? Constants.TRUE:Constants.FALSE;
					
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
	self.getStudents = function(order_no, add) {
		var add = (add) ? add:0;

		self.errors = Constants.FALSE;

		var order_no = (order_no) ? order_no : self.invoice_detail.order_no;

		if(add == 1){
			$scope.ui_block();
		}

		ManageParentPaymentService.getStudents(order_no).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.students = response.data;
					if(self.subscription) {
						self.students.price = (self.subscription.price) ? self.subscription.price:0;
					}
					
					self.computation();
				}
			}
			if(add == 1){
				$scope.ui_unblock();
			}
		}).error(function(response){
			self.errors = $scope.internalError();
			if(add == 1){
				$scope.ui_unblock();
			}
		});
	}

	self.computation = function(add) {
		self.payment_total.subtotal = 0.00;
		for(var i = 0; i < self.students.length; i++){
			self.payment_total.price = (add == 1) ? self.payment_total.s_price : self.students.price;

	        self.payment_total.subtotal = self.payment_total.subtotal + parseInt(self.payment_total.price);
	    }

	    self.payment_total.subtotal = self.payment_total.subtotal + '.00';
	    self.payment_total.total = (self.discount.percentage != 0) ? (parseInt(self.payment_total.subtotal) * (parseInt(self.discount.percentage)/100)) : self.payment_total.subtotal;
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
					self.discount = {};
					angular.forEach(response.data, function(value, key){
						self.discount = value;
					});
				}
			}
		}).error(function(response){
			self.errors = $scope.internalError();
		});
	}
	self.setDate = function() {
		var date = new Date();
		if(self.no_days) {
			self.payment_total.s_price = ($('#subscription').find(':selected').data('id') != null) ? $('#subscription').find(':selected').data('id'):0;
			self.students.price = (self.payment_total.s_price) ? self.payment_total.s_price: self.students.price;
			self.date.dis_start_date = $filter('date')(date, 'yyyyMMdd');
			self.date.start_date = $filter('date')(date, 'dd/MM/yyyy');

			date.setDate(date.getDate() + parseInt(self.no_days));

			self.date.dis_end_date = $filter('date')(date, 'yyyyMMdd');
			self.date.end_date = $filter('date')(date, 'dd/MM/yyyy');
			self.computation(1);
		} else {
			self.date = {};
		}
	}

	self.getOrderNo = function() {
		self.errors = Constants.FALSE;
		self.order = {};

		ManageParentPaymentService.getOrderNo(self.user_id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.order = response.data;
					self.saveOrder();
				}
			}
		}).error(function(response){
			self.errors = $scope.internalError();
		});
	}

	self.saveOrder = function() {
		self.errors = Constants.FALSE;

		self.order_details = {};
		self.order_details.client_id = self.user_id;
		self.order_details.client_name = $scope.user.first_name + ' ' + $scope.user.last_name;
		self.order_details.order_no = self.order.order_no;
		self.order_details.payment_status = Constants.PENDING;

		ManageParentPaymentService.saveOrder(self.order_details).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.invoice_detail = response.data;
					self.getStudents(self.invoice_detail.order_no, 1);
				}
			}
		}).error(function(response){
			self.errors = $scope.internalError();
		});
	}

	self.addStudentOrderByEmail = function() {
		self.errors = Constants.FALSE;
		self.add.success = Constants.FALSE;

		self.add.parent_user_id = self.client.user_id;
		self.add.order_id = (self.invoice_detail) ? self.invoice_detail.id : self.invoice.id;
		self.add.price = ($('#subscription').find(':selected').data('id') != null) ? $('#subscription').find(':selected').data('id'):0;
		self.add.email = (self.add.email == null) ? Constants.EMPTY_STR : self.add.email;

		$scope.ui_block();
		ManageParentPaymentService.addStudentOrderByEmail(self.add).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.student_detail = response.data;
					self.add.success = Constants.TRUE;
					self.getSubscriptionList();
					self.getStudents(self.invoice_detail.order_no, 1);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.searchName = function() {
		self.errors = Constants.FALSE;
		var name = self.add.name;
		self.validation.s_loading = Constants.TRUE;
		self.validation.s_error = Constants.FALSE;
		ManageParentPaymentService.searchName(name).success(function(response){
			self.validation.s_loading = Constants.FALSE;
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.validation.s_error = response.errors[0].message;
				}else if(response.data){
					self.names = {};
					self.names = response.data.record;
				}
			}
		}).error(function(response){
			self.errors = $scope.internalError();
			self.validation.s_loading = Constants.FALSE;
		});
	}

	self.selectName = function(name) {
		self.add.username = name.user.username;
		self.add.name = name.first_name + ' ' + name.last_name;
		self.names = Constants.FALSE;
	}

	self.addStudentOrderByUsername = function() {
		self.errors = Constants.FALSE;
		self.add.success = Constants.FALSE;

		self.add.parent_user_id = self.client.user_id;
		self.add.order_id = (self.invoice_detail) ? self.invoice_detail.id : self.invoice.id;
		self.add.price = ($('#subscription').find(':selected').data('id') != null) ? $('#subscription').find(':selected').data('id'):0;
		
		$scope.ui_block();
		ManageParentPaymentService.addStudentOrderByUsername(self.add).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.student_detail = response.data;
					self.add.success = Constants.TRUE;
					self.getStudents(self.invoice_detail.order_no, 1);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
	self.deleteInvoice = function(id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.ui_block();
		ManageParentPaymentService.deleteInvoice(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.success = Constants.TRUE;
					self.listPayments(1);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
}