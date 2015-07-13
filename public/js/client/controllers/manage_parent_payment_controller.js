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
				self.invoice = {};
				self.active_add = Constants.TRUE;
				self.active_list = Constants.FALSE;
				self.active_view = Constants.FALSE;
				self.getSubscriptionList();
				self.getClient(self.user_id);
				break;

			case Constants.ACTIVE_VIEW:
				self.date = {};
				self.add = {};
				self.invoice = {};
				self.active_add = Constants.FALSE;
				self.active_list = Constants.FALSE;
				self.active_view = Constants.TRUE;
				self.getSubscriptionList();
				self.getClient(self.user_id);
				self.viewPayment(id, self.cond);
				break;

			case Constants.ACTIVE_LIST:
			default:
			self.add = {};
			self.active_list = Constants.TRUE;
			self.active_add = Constants.FALSE;
			self.active_view = Constants.FALSE;
			break;
		}

	$("html, body").animate({ scrollTop: 0 }, "slow");
	
	}

	self.list = function(cond) {
		
		var cond = (cond) ? cond:0;
		if(self.active_list || self.active_view) {
			self.listPayments(cond);
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

		if(self.remove_cond == 'list'){
			self.cond = 1;
		}
		if(self.cond != 1) {
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
					if(self.invoice.discount != '0.00') {
						self.invoice.discount = self.discount.percentage;
					}else{
						self.invoice.discount = 0;
					}

					self.invoice.subtotal = self.subtotal;
					self.invoice.dis_date_start = self.invoice.date_start;
					self.invoice.dis_date_end = self.invoice.date_end;

					var date = new Date();
					self.invoice.date_start = $filter('date')(new Date(self.invoice.date_start), 'yyyyMMdd');
					
					self.invoice.date_end = $filter('date')(new Date(self.invoice.date_end), 'yyyyMMdd');
					
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
		self.invoice.subtotal = 0.00;
		for(var i = 0; i < self.students.length; i++){
			self.invoice.price = (add == 1) ? self.invoice.s_price : self.students.price;
	        self.invoice.subtotal = self.invoice.subtotal + parseInt(self.invoice.price);
	    }

	    self.invoice.subtotal = self.invoice.subtotal + '.00';
	    self.invoice.total_amount = (self.discount.percentage != '0.00') ? (parseInt(self.invoice.subtotal) * (parseInt(self.discount.percentage)/100)) : self.invoice.subtotal;
	}

	self.getSubscription = function(id) {
		self.errors = Constants.FALSE;

		ManageParentPaymentService.getSubscription(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){

					self.subscription = response.data;
					self.getStudents(self.invoice.order_no);
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
					if(self.discount.length == null){
						self.discount.percentage = 0;
					}
				}
			}
		}).error(function(response){
			self.errors = $scope.internalError();
		});
	}
	self.setDate = function(flag) {
		var date = new Date();
		if(self.no_days) {
			self.invoice.h_date_start = null;
			self.invoice.h_date_end = null;

			self.payment_total.s_price = ($('#subscription').find(':selected').data('price') != null) ? $('#subscription').find(':selected').data('price'):0;
			self.invoice.s_price = ($('#subscription').find(':selected').data('price') != null) ? $('#subscription').find(':selected').data('price'):0;
			self.invoice.price = (self.payment_total.s_price) ? self.payment_total.s_price: self.students.price;
			
			self.invoice.date_start = $filter('date')(date, 'yyyyMMdd');
			self.invoice.dis_date_start = date;

			var end_date = new Date(date.getTime());
			end_date.setDate(end_date.getDate() + parseInt(self.no_days));

			self.invoice.date_end = $filter('date')(end_date, 'yyyyMMdd');
			self.invoice.dis_date_end = end_date;
			self.computation(1);
		}
	}

	self.getOrderNo = function() {
		self.errors = Constants.FALSE;
		self.order = {};
		self.invoice = {};
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
		self.success = Constants.FALSE;

		self.add.parent_id = self.client.id;
		self.add.order_id = (self.invoice_detail) ? self.invoice_detail.id : self.invoice.id;
		self.add.price = ($('#subscription').find(':selected').data('price') != null) ? $('#subscription').find(':selected').data('price'):0;
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
					if(self.invoice){
						self.getStudents(self.invoice.order_no, 1);
					}else{
						self.getStudents(self.invoice_detail.order_no, 1);
					}
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
		ManageParentPaymentService.searchName(name, $scope.user.id).success(function(response){
			self.validation.s_loading = Constants.FALSE;
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.validation.s_error = response.errors[0].message;
				}else if(response.data){
					self.names = {};
					self.names = response.data.records;
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
		self.success = Constants.FALSE;

		self.add.parent_id = self.client.id;
		self.add.order_id = (self.invoice_detail) ? self.invoice_detail.id : self.invoice.id;
		self.add.price = ($('#subscription').find(':selected').data('price') != null) ? $('#subscription').find(':selected').data('price'):0;
		$scope.ui_block();
		ManageParentPaymentService.addStudentOrderByUsername(self.add).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.student_detail = response.data;
					self.add.success = Constants.TRUE;
					self.getSubscriptionList();
					if(self.invoice){
						self.getStudents(self.invoice.order_no, 1);
					}else{
						self.getStudents(self.invoice_detail.order_no, 1);
					}
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
	self.deleteInvoice = function(id) {
		var id = (id) ? id:self.remove_invoice_id
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		$scope.ui_block();
		ManageParentPaymentService.deleteInvoice(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.success = Constants.TRUE;
					self.list();
					self.setActive('list', '', 1);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.savePayment = function(flag){
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.add.success = Constants.FALSE;

		self.invoice.invoice_date = $filter('date')(new Date(), 'yyyyMMdd');
		self.invoice.order_no = (flag == 'add') ? self.invoice_detail.order_no : self.invoice.order_no;
		self.invoice.client_id = (flag == 'add') ? parseInt(self.invoice_detail.client_id):self.invoice.client_id;
		self.invoice.client_name = (flag == 'add') ? self.invoice_detail.client_name:self.invoice.client_name;
		self.invoice.dis_date_start = (self.invoice.h_date_start != null) ? $filter('date')(new Date(self.invoice.h_date_start), 'yyyyMMdd'): self.invoice.dis_start_date;
		self.invoice.dis_date_end = (self.invoice.h_date_end != null) ? $filter('date')(new Date(self.invoice.h_date_end), 'yyyyMMdd') : self.invoice.dis_end_date;
		self.invoice.seats_total = self.students.length;
		self.invoice.subscription = $('#subscription').find(':selected').data('name');
		self.invoice.subscription_id = $('#subscription').find(':selected').data('id');
		self.invoice.payment_status = Constants.PENDING;
		self.invoice.discount_type = null;
		self.invoice.discount_id = 0;
		self.invoice.id = (flag == 'add') ? self.invoice_detail.id:self.invoice.id;
		$scope.ui_block();
		ManageParentPaymentService.updatePayment(self.invoice).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.setActive('list');
				}
			}
			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.addPayment = function(flag) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.add.success = Constants.FALSE;
		self.paying = Constants.TRUE;
		self.invoice.invoice_date = $filter('date')(new Date(), 'yyyyMMdd');
		self.invoice.id = (flag == 'add') ? self.invoice_detail.id: self.invoice.id;
		self.invoice.order_no = (flag == 'add') ? self.invoice_detail.order_no : self.invoice.order_no;
		self.invoice.client_id = (flag == 'add') ? self.invoice_detail.client_id:self.invoice.client_id;
		self.invoice.client_name = (flag == 'add') ? self.invoice_detail.client_name:self.invoice.client_name;
		self.invoice.seats_total = self.students.length;
		self.invoice.total_amount = self.invoice.total_amount;
		self.invoice.subscription_id = $('#subscription').find(':selected').data('id');
		self.invoice.payment_status = Constants.PENDING;
		$scope.ui_block();

		ManageParentPaymentService.updatePayment(self.invoice).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
					$scope.ui_unblock();
				} else if(response.data) {
					self.getPaymentUri();
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	$window.addEventListener('beforeunload', function() {
		if(!self.paying && self.active_add) {
			self.deleteInvoice(self.invoice_detail.id);	
		}
	});

	self.getPaymentUri = function() {
		self.payment = {};
		self.payment.invoice_id = self.invoice.id;
		self.payment.quantity = Constants.TRUE;
		self.payment.price = self.invoice.total_amount;
		self.payment.client_id = self.invoice.client_id;
		self.payment.order_no = self.invoice.order_no;

		var base_url = $("#base_url_form input[name='base_url']").val();
		self.payment.success_callback_uri = base_url + "/" + angular.lowercase(Constants.CLIENT) + "/parent/payment/success"
		self.payment.fail_callback_uri = base_url + "/" + angular.lowercase(Constants.CLIENT) + "/parent/payment/fail"

		ManageParentPaymentService.getPaymentUri(self.payment).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
					$scope.ui_unblock();
				} else if(response.data) {
					$window.location.href = response.data.url;
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.removeStudent = function(flag) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.add.success = Constants.FALSE;

		ManageParentPaymentService.removeStudent(self.remove_student_id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.success = Constants.TRUE;
					if(flag == 'add'){
						self.getStudents(self.invoice_detail.id);
					}else{
						self.getStudents(self.invoice.id);
					}
					
				}
			}
			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});

	}
	self.confirmCancelAdd = function(id) {
		self.remove_student_id = id;
		self.errors = Constants.FALSE;
		self.confirm_delete = Constants.TRUE;
		$("#remove_subscription_modal_add").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.confirmRemoveInvoice = function(id, cond) {
		self.remove_invoice_id = id;
		self.remove_cond = cond;
		self.errors = Constants.FALSE;
		self.confirm_delete = Constants.TRUE;
		$("#remove_subscription_modal_invoice").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}
	self.confirmCancelView = function(id) {
		self.remove_student_id = id;
		self.errors = Constants.FALSE;
		self.confirm_delete = Constants.TRUE;
		$("#remove_subscription_modal_view").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.confirmCancel = function(id) {
		self.remove = {};
		self.remove.id = id;
		self.errors = Constants.FALSE;
		self.confirm_delete = Constants.TRUE;
		$("#cancel_subscription_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.confirmCancelInvoice = function(id) {
		self.cancel_invoice_id = id;
		self.errors = Constants.FALSE;
		self.confirm_delete = Constants.TRUE;
		$("#cancel_subscription_modal_invoice").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.cancelInvoice = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		ManageParentPaymentService.cancelInvoice(self.cancel_invoice_id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.listPayments();
					self.setActive('list', '', 1);				
				}
			}
			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
}