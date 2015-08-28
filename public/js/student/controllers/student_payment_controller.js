angular.module('futureed.controllers')
	.controller('StudentPaymentController', StudentPaymentController);

StudentPaymentController.$inject = ['$scope', '$window', '$filter', 'apiService', 'StudentPaymentService', 'SearchService', 'TableService'];

function StudentPaymentController($scope, $window, $filter, apiService, StudentPaymentService, SearchService, TableService) {

	var self = this;

	SearchService(self);
	self.searchDefaults();

	TableService(self);
	self.tableDefaults();

	self.user_id = $scope.user.id;

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.fields = [];

		self.active_list = Constants.FALSE;
		self.active_add = Constants.FALSE;
		self.active_view = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_ADD 	:
				self.active_add = Constants.TRUE;

				self.invoice = {};
				self.invoice.student_id = $scope.user.id;
				break;

			case Constants.ACTIVE_VIEW  : 
				self.active_view = Constants.TRUE;
				self.paymentDetail(id);
				break;

			case Constants.ACTIVE_LIST 	:

			default:
				self.active_list = Constants.TRUE;
				break;
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

	self.list = function() {
		self.listPayments();
	}

	self.listPayments = function() {
		self.errors = Constants.FALSE;
		
		self.table.size = Constants.CUSTOM_TABLE_SIZE;
		self.search.student_id = $scope.user.id;

		$scope.ui_block();
		StudentPaymentService.list(self.search, self.table).success(function(response) {
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

	self.listSubscription = function() {
		self.subscriptions = [];

		StudentPaymentService.listSubscription().success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.subscriptions = response.data.records;
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	self.getSubjects = function() {
		self.subjects = [];

		StudentPaymentService.getSubjects().success(function(response) {
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

	self.setSubscription = function() {
		$scope.ui_block();
		StudentPaymentService.subscriptionDetails(self.invoice.subscription_id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					var subscription = response.data;
					computeDays(subscription);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	function computeDays(subscription) {
		var start_date = new Date();
			self.invoice.date_start = $filter('date')(start_date, 'yyyyMMdd');
			self.invoice.dis_date_start = start_date;

		var end_date = new Date(start_date.getTime());
			end_date.setDate(end_date.getDate() + parseInt(subscription.days));

			self.invoice.date_end = $filter('date')(end_date, 'yyyyMMdd');
			self.invoice.dis_date_end = end_date;

		self.invoice.seats_total = Constants.TRUE;
		self.invoice.seats_taken = Constants.TRUE;
		self.invoice.total_amount = parseInt(subscription.price);
		
		self.invoice.sub_total = parseInt(subscription.price);
		self.invoice.discount = Constants.FALSE;
	}

	self.updateSubscription = function(save) {
		self.fields = [];
		self.errors = Constants.FALSE;

		self.invoice.order_date = $filter('date')(new Date(), 'yyyyMMdd');
		self.invoice.student_id = $scope.user.id;

		$scope.ui_block();
		StudentPaymentService.updateSubscription(self.invoice).success(function(response) {
			if(response.errors) {
				self.errors = $scope.errorHandler(response.errors);

				angular.forEach(response.errors, function(value, key) {
					self.fields[value.field] = Constants.TRUE;
				});

				$scope.ui_unblock();
			} else if(response.data) {
				if(save) {
					self.setActive();
					$scope.ui_unblock();
				} else {
					self.invoice = response.data;
					self.getPaymentUri();
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.saveSubscription = function() {
		self.paySubscription(Constants.TRUE);
	}

	self.paySubscription = function(save) {
		self.fields = [];
		self.errors = Constants.FALSE;

		self.invoice.order_date = $filter('date')(new Date(), 'yyyyMMdd');
		self.invoice.payment_status = Constants.PENDING;

		$scope.ui_block();
		StudentPaymentService.paySubscription(self.invoice).success(function(response) {
			if(response.errors) {
				self.errors = $scope.errorHandler(response.errors);

				angular.forEach(response.errors, function(value, key) {
					self.fields[value.field] = Constants.TRUE;
				});

				$scope.ui_unblock();
			} else if(response.data) {
				if(save) {
					self.setActive();
					$scope.ui_unblock();
				} else {
					self.invoice = response.data;
					self.getPaymentUri();
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.getPaymentUri = function() {
		var payment = {};
			payment.invoice_id = self.invoice.invoice.id;
			payment.quantity = Constants.TRUE;
			payment.price = self.invoice.total_amount;
			payment.client_id = self.invoice.student_id;
			payment.order_no = self.invoice.order_no;

		var base_url = $("#base_url_form input[name='base_url']").val();
			payment.success_callback_uri = base_url + "/" + angular.lowercase(Constants.STUDENT) + "/payment/success"
			payment.fail_callback_uri = base_url + "/" + angular.lowercase(Constants.STUDENT) + "/payment/fail"

		StudentPaymentService.getPaymentUri(payment).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
					$scope.ui_unblock();
				} else if(response.data) {
					self.paying = Constants.TRUE;
					$window.location.href = response.data.url;
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.paymentDetail = function(id) {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		StudentPaymentService.paymentDetails(id).success(function(response) {
			if(response.errors) {
				self.errors = $scope.errorHandler(response.errors);
			} else if(response.data) {
				var data = response.data;

				self.invoice = {};
				self.invoice.payment_status = data.payment_status;
				self.invoice.subscription_id = data.subscription_id;
				self.invoice.order_id = data.order.id;
				self.invoice.subject_id = data.invoice_detail[0].classroom.subject_id;
				self.invoice.subject_name = data.invoice_detail[0].classroom.subject.name;
				
				computeDays(data.subscription);
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});;
	}
}