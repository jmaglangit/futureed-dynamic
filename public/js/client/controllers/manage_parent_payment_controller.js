angular.module('futureed.controllers')
	.controller('ManageParentPaymentController', ManageParentPaymentController);

ManageParentPaymentController.$inject = ['$scope','$window', '$filter', 'ManageParentPaymentService', 'apiService', 'TableService', 'SearchService'];

function ManageParentPaymentController($scope, $window, $filter, ManageParentPaymentService, apiService, TableService, SearchService) {
	var self = this;
	
	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.user_id = $scope.user.id;

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.validation = {};

		self.active_add = Constants.FALSE;
		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;

		switch(active){
			case Constants.ACTIVE_ADD 	:
				self.active_add = Constants.TRUE;
				break;

			case Constants.ACTIVE_VIEW 	:
				self.active_view = Constants.TRUE;
				self.viewPayment(id);
				break;

			case Constants.ACTIVE_LIST 	:

			default:
				self.active_list = Constants.TRUE;
				break;
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.list = function(cond) {
		if(self.active_list || self.active_view) {
			self.listPayments();
		}
	}

	self.searchFnc = function(event) {
		self.tableDefaults();
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
		self.records = [];

		self.search.client_id = $scope.user.id;
		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		ManageParentPaymentService.list(self.search, self.table).success(function(response) {
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
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

	self.viewPayment = function(id) {
		self.errors = Constants.FALSE;
		self.client = {};
		
		$scope.ui_block();
		ManageParentPaymentService.viewPayment(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					var data = response.data;
					
					self.invoice = {
						  id				: 	data.id
						, client_id			: 	data.client_id
						, client_name 		: 	data.client_name
						, subscription_id 	: 	data.subscription_id
						, date_start 		: 	data.date_start
						, date_end 			: 	data.date_end
						, order_no 			: 	data.order_no
						, subject_id 		: 	data.invoice_detail[0].classroom.subject_id
						, payment_status 	: 	data.payment_status
						, discount 			: 	data.discount
						, discount_id 		: 	data.discount_id
						, discount_type 	: 	data.discount_type
						, seats_total 		: 	data.seats_total
						, total_amount 		: 	data.total_amount
					}

					self.getStudents(self.invoice.order_no, self.invoice);
					if(angular.equals(self.invoice.payment_status, Constants.PAID)) {
						getClient(self.invoice.client_id)
					}
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	getClient = function(id) {
		ManageParentPaymentService.getClient(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.client = response.data;
					console.log(self.client);
				}
			}
		}).error(function(response){
			self.errors = $scope.internalError();
		});
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

	//get Students associated to the payment
	self.getStudents = function(order_no, record) {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		ManageParentPaymentService.getStudents(order_no).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.students = response.data;
					if(self.invoice.subscription_id) {
						self.setSubscription(record);
					}
				}
			}
			
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	// get list of subscription available
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

	self.setSubscription = function(record) {
		self.fields = [];
		var subscription = {};

		angular.forEach(self.subscriptions, function(value, key) {
			if(angular.equals(parseInt(value.id), parseInt(self.invoice.subscription_id))) {
				subscription = value;
				return;	
			}
		});

		self.invoice.sub_total = Constants.FALSE;
		self.invoice.seats_total = Constants.FALSE;
		self.invoice.total_amount = Constants.FALSE;

		if(subscription.id) {
			// set date range based on subscription
			var start_date = (record) ? new Date(self.invoice.date_start) : new Date();
				self.invoice.date_start = $filter('date')(start_date, 'yyyyMMdd');
				self.invoice.dis_date_start = start_date;

			var end_date = new Date(start_date.getTime());
				end_date.setDate(end_date.getDate() + parseInt(subscription.days));

				self.invoice.date_end = $filter('date')(end_date, 'yyyyMMdd');
				self.invoice.dis_date_end = end_date;

			self.selected_subscription = subscription;
		}

		// get subtotal by students
		angular.forEach(self.students, function(value, key) {
			value.price = (subscription.price) ? subscription.price : Constants.FALSE;
			self.invoice.seats_total++;
			self.invoice.sub_total += parseInt(subscription.price);
		});

		// get total with discount
		getDiscounts();
	}

	getDiscounts = function() {
		self.invoice.total_amount = self.invoice.sub_total;
		self.invoice.discount_type = Constants.CLIENT;

		getClientDiscount(self.invoice.client_id, function(response) {
			if(response.data.length) {
				var data = response.data[0];

				self.invoice.discount_id = data.id;
				self.invoice.discount = data.percentage;
				self.invoice.total_amount = parseInt(self.invoice.total_amount) - parseInt(self.invoice.total_amount) * (parseInt(data.percentage) / 100);
			} else {
				self.invoice.discount = Constants.FALSE;
				self.invoice.discount_id = Constants.FALSE;
			}
		});
	}

	//get client discount
	getClientDiscount = function(id, successCallback){
		self.errors = Constants.FALSE;

		ManageParentPaymentService.getClientDiscount(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
					if(successCallback) {
						successCallback(response);
					}
				}
			}
		}).error(function(response){
			self.errors = $scope.internalError();
		});
	}

	// currently not used due to unauthorized access.
	getBulkDiscount = function(min_seat, successCallback) {
		ManageParentPaymentService.getBulkDiscount(min_seat).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					if(successCallback) {
						successCallback(response);
					}
				}
			}
		}).error(function(response){
			self.errors = $scope.internalError();
		});
	}

	// Add Payment 1 - Get order number.
	self.getOrderNo = function() {
		self.errors = Constants.FALSE;
		self.order = {};
		self.invoice = {};
		ManageParentPaymentService.getOrderNo(self.user_id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					var order = response.data;
						self.invoice.order_id = order.id;
						self.invoice.order_no = order.order_no;

					self.addInvoice();
				}
			}
		}).error(function(response){
			self.errors = $scope.internalError();
		});
	}

	// Add Payment 2 - Add invoice.
	self.addInvoice = function() {
		self.errors = Constants.FALSE;

		self.invoice.client_id = self.user_id;
		self.invoice.client_name = $scope.user.first_name + " " + $scope.user.last_name;

		var order_details = {};
			order_details.client_id = self.invoice.client_id;
			order_details.client_name = self.invoice.client_name;
			order_details.order_no = self.invoice.order_no;
			order_details.payment_status = Constants.PENDING;

		ManageParentPaymentService.addInvoice(order_details).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.invoice_detail = response.data;
					self.invoice.id = self.invoice_detail.id;
					
					// self.getStudents(self.invoice.order_no);
				}
			}
		}).error(function(response){
			self.errors = $scope.internalError();
		});
	}

	self.addStudentOrderByEmail = function() {
		self.fields = [];
		self.no_days = Constants.EMPTY_STR;
		self.errors = Constants.FALSE;
		self.add.success = Constants.FALSE;
		self.success = Constants.FALSE;

		self.add.parent_id = self.user_id;
		self.add.order_id = self.invoice.order_id;
		self.add.price = (self.selected_subscription) ? parseInt(self.selected_subscription.price) : Constants.FALSE;
		self.add.subject_id = self.invoice.subject_id;

		$scope.ui_block();
		ManageParentPaymentService.addStudentOrderByEmail(self.add).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
					self.add = {};
				}else if(response.data){
					self.add = {};
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

					if(self.names.length == 0){
						self.names = Constants.FALSE;
						self.validation.s_error = Constants.MSG_U_NOTEXIST;
					}
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
		self.fields = [];
		
		self.add.success = Constants.FALSE;
		self.success = Constants.FALSE;

		self.add.parent_id = self.user_id;
		self.add.order_id = self.invoice.order_id;
		self.add.price = (self.selected_subscription) ? parseInt(self.selected_subscription.price) : Constants.FALSE;
		self.add.subject_id = self.invoice.subject_id;

		$scope.ui_block();
		ManageParentPaymentService.addStudentOrderByUsername(self.add).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
					self.add = {};
				}else if(response.data){
					self.add = {};
					self.success = ["Successfully added a student"];
					
					self.getStudents(self.invoice.order_no);
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

	self.savePayment = function(){
		self.errors = Constants.FALSE;
		self.fields = [];

		self.invoice.parent_id = self.user_id;
		self.invoice.order_date = $filter('date')(new Date(), 'yyyyMMdd');

		$scope.ui_block();
		ManageParentPaymentService.paySubscription(self.invoice).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
					
					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.setActive();
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.addPayment = function() {
		self.errors = Constants.FALSE;
		self.fields = [];

		self.paying = Constants.TRUE;

		self.invoice.parent_id = self.user_id;
		self.invoice.order_date = $filter('date')(new Date(), 'yyyyMMdd');

		$scope.ui_block();
		ManageParentPaymentService.paySubscription(self.invoice).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
					
					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});

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
		var payment = {};
			payment.invoice_id = self.invoice.id;
			payment.quantity = Constants.TRUE;
			payment.price = self.invoice.total_amount;
			payment.client_id = self.invoice.client_id;
			payment.order_no = self.invoice.order_no;

		var base_url = $("#base_url_form input[name='base_url']").val();
			payment.success_callback_uri = base_url + "/" + angular.lowercase(Constants.CLIENT) + "/parent/payment/success"
			payment.fail_callback_uri = base_url + "/" + angular.lowercase(Constants.CLIENT) + "/parent/payment/fail"

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

	self.removeStudent = function() {
		self.errors = Constants.FALSE;

		ManageParentPaymentService.removeStudent(self.remove_student_id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.success = ["Successfully removed a student."];
					self.getStudents(self.invoice.order_no);
				}
			}
			
		}).error(function(response) {
			self.errors = $scope.internalError();
		});

	}
	self.confirmCancelAdd = function(id) {
		self.errors = Constants.FALSE;

		self.remove_student_id = id;
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

	self.getSubject = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		ManageParentPaymentService.getSubject().success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.subjects = response.data.records;			
				}
			}
			
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}
}