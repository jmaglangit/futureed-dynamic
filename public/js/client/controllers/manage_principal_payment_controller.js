angular.module('futureed.controllers')
	.controller('ManagePrincipalPaymentController', ManagePrincipalPaymentController);

ManagePrincipalPaymentController.$inject = ['$scope'
	, '$window'
	, '$filter'
	, 'managePrincipalPaymentService'
	, 'clientProfileApiService'
	, 'apiService'
	, 'TableService'
	, 'SearchService'];

function ManagePrincipalPaymentController($scope, $window, $filter, managePrincipalPaymentService, clientProfileApiService, apiService, TableService, SearchService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.classroom = {};
	self.invoice = {};

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.records = [];
		self.validation = {};

		self.active_list = Constants.FALSE;
		self.active_add = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_edit = Constants.FALSE;

		self.tableDefaults();
		self.searchDefaults();

		switch(active) {
			case Constants.ACTIVE_VIEW:
				self.active_view = Constants.TRUE;
				break;

			case Constants.ACTIVE_ADD :
				self.fields = [];
				self.classroom = {};
				self.invoice = {};

				self.invoice.discount = Constants.FALSE;
				self.invoice.seats_total = Constants.FALSE;
				self.invoice.sub_total = Constants.FALSE;
				self.invoice.total_amount = Constants.FALSE;

				self.active_add = Constants.TRUE;
				break;

			case Constants.ACTIVE_LIST:
			default:
				self.success = Constants.FALSE;
				self.active_list = Constants.TRUE;
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

		$scope.ui_block();
		managePrincipalPaymentService.list(self.search, self.table).success(function(response) {
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

		managePrincipalPaymentService.listSubscription().success(function(response) {
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

	self.listClassroom = function(order_no) {
		self.classrooms = [];
		self.search.order_no = order_no;

		$scope.ui_block();
		managePrincipalPaymentService.listClassrooms(self.search, self.table).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.classrooms = response.data.record;

					angular.forEach(self.classrooms, function(value, key) {
						value.price = (self.invoice.subscription) ? value.seats_total * self.invoice.subscription.price : Constants.FALSE;
					});

					if(self.invoice.subscription) {
						self.setPrice(self.invoice.subscription);
					}
					
					self.updatePageCount(response.data);
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
		self.success = Constants.FALSE;
		self.invoice.invoice_date = $filter('date')(new Date(), 'yyyyMMdd');
		self.invoice.invoice_id = self.invoice.id;

		$scope.ui_block();
		managePrincipalPaymentService.updatePayment(self.invoice).success(function(response) {
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

	self.getPaymentUri = function() {
		self.payment = {};
		self.payment.invoice_id = self.invoice.id;
		self.payment.quantity = Constants.TRUE;
		self.payment.price = self.invoice.total_amount;
		self.payment.client_id = self.invoice.client_id;
		self.payment.order_no = self.invoice.order_no;

		var base_url = $("#base_url_form input[name='base_url']").val();
		self.payment.success_callback_uri = base_url + "/" + angular.lowercase(Constants.CLIENT) + "/principal/payment/success"
		self.payment.fail_callback_uri = base_url + "/" + angular.lowercase(Constants.CLIENT) + "/principal/payment/fail"

		managePrincipalPaymentService.getPaymentUri(self.payment).success(function(response) {
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
	
	/**
	* Get unique order number.
	*/
	self.getOrderNo = function() {
		managePrincipalPaymentService.getOrderNo($scope.user.id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.invoice.order_no = response.data.order_no;
					self.addInvoice();
					self.listClassroom(self.invoice.order_no);
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	self.addInvoice = function() {
		self.invoice.client_id = $scope.user.id;
		self.invoice.client_name = $scope.user.first_name + " " + $scope.user.last_name;
		self.invoice.payment_status = "Pending";

		managePrincipalPaymentService.addInvoice(self.invoice).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.invoice.id = response.data.id;
				}
			}
		}).error(function() {
			self.errors = $scope.internalError();
		});
	}

	self.getSchoolCode = function() {
		clientProfileApiService.getClientDetails($scope.user.id).success(function(response) {
			if(response.errors) {
				self.errors = $scope.errorHandler(response.errors);
			} else if(response.data) {
				self.school = response.data;
				self.invoice.school_code = response.data.school_code;
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	self.suggestTeacher = function() {
		self.errors = Constants.FALSE;
		self.teachers = {};
		self.validation = {};
		self.validation.c_loading = Constants.TRUE;
		self.classroom.client_role = Constants.TEACHER;
		self.classroom.school_code = self.invoice.school_code;

		managePrincipalPaymentService.getTeacherDetails(self.classroom).success(function(response) {
			self.validation.c_loading = Constants.FALSE;
			
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if (response.errors) {
					self.validation.c_error = response.errors[0].message;
				} else if(response.data) {
					if(response.data.length) {
						self.teachers = response.data;
					} else {
						self.validation.c_error = Constants.MSG_U_NOTEXIST;
					}
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			self.validation.c_loading = Constants.FALSE;
		});
	}

	self.selectTeacher = function(teacher) {
		self.classroom.client_id = teacher.id;
		self.classroom.client_name = teacher.first_name + " " + teacher.last_name;
		self.teachers = {};
	}

	self.clearClassroom = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.fields = [];
		self.classroom = {};
		self.validation = {};

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.addClassroom = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.fields = [];
		self.classroom.seats_taken = Constants.FALSE;
		self.classroom.order_no = self.invoice.order_no;
		self.classroom.status = "Enabled";

		$scope.ui_block();
		managePrincipalPaymentService.addClassroom(self.classroom).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.classroom = {};
					self.search = {};
					self.success = "Successfully added a new classroom.";
					self.listClassroom(self.invoice.order_no);

					$("html, body").animate({ scrollTop: 0 }, "slow");
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.removeClassroom = function(id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.ui_block();
		managePrincipalPaymentService.removeClassroom(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.listClassroom(self.invoice.order_no);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.setPrice = function(subscription) {
		self.errors = Constants.FALSE;

		self.invoice.seats_total = Constants.FALSE;
		self.invoice.sub_total = Constants.FALSE;
		self.invoice.total_amount = Constants.FALSE;

		if(!subscription) {
			self.invoice.dis_date_start = Constants.EMPTY_STR;
			self.invoice.date_start = Constants.EMPTY_STR;

			self.invoice.dis_date_end = Constants.EMPTY_STR;
			self.invoice.date_end = Constants.EMPTY_STR;
		}

		$scope.ui_block();
		managePrincipalPaymentService.subscriptionDetails(self.invoice.subscription_id).success(function(response) {
			if(response.errors) {
				self.errors = $scope.errorHandler(response.errors);
			} else if(response.data) {
				var subscription = response.data;
				self.invoice.subscription = subscription;
				
				var price = Constants.FALSE;
				
				if(!angular.equals(self.invoice.payment_status, Constants.PENDING)) {
					angular.forEach(self.classrooms, function(value, key) {
						self.invoice.seats_total += value.seats_total;
					});

					self.invoice.dis_date_start = new Date(self.invoice.date_start).getTime();
					self.invoice.dis_date_end = new Date(self.invoice.date_end).getTime();

					self.invoice.sub_total = subscription.price * self.invoice.seats_total;
					self.invoice.total_amount = self.invoice.sub_total - ( self.invoice.sub_total * (self.invoice.discount / 100) );
				} else {
					self.invoice.discount = Constants.FALSE;
					self.invoice.discount_id = Constants.EMPTY_STR;
					self.invoice.discount_type = Constants.EMPTY_STR;

					if(subscription.price) {
						var date = new Date();
							self.invoice.date_start = $filter('date')(date, 'yyyyMMdd');
							self.invoice.dis_date_start = date.getTime();
							
							date.setDate(date.getDate() + subscription.days);
							
							self.invoice.date_end = $filter('date')(date, 'yyyyMMdd');
							self.invoice.dis_date_end = date.getTime();

						angular.forEach(self.classrooms, function(value, key) {
							value.price = subscription.price * value.seats_total;
							self.invoice.seats_total += value.seats_total;
						});

						self.invoice.sub_total = subscription.price * self.invoice.seats_total;
					} else {
						angular.forEach(self.classrooms, function(value, key) {
							value.price = Constants.FALSE;
						});
					}

					if(self.invoice.sub_total) {
						self.getDiscount();
					}
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.getDiscount = function() {
		var client_id = $scope.user.id;
		self.invoice.total_amount = self.invoice.sub_total;

		self.getClientDiscount(client_id);
	}

	self.getClientDiscount = function() {
		managePrincipalPaymentService.getClientDiscount($scope.user.id).success(function(response) {
			if(response.errors) {
				self.errors = $scope.errorHandler(response.errors);
			} else if(response.data) {
				if(response.data[0]) {
					self.invoice.discount = response.data[0].percentage;
					self.invoice.discount_id = response.data[0].id;
					self.invoice.discount_type = "Client";
					self.invoice.total_amount = self.invoice.sub_total - ( self.invoice.sub_total * (self.invoice.discount / 100) );
				} else {
					self.getBulkDiscount(self.invoice.seats_total);
				}
			}
		});
	}

	self.getBulkDiscount = function(min_seats) {
		managePrincipalPaymentService.getBulkDiscount(min_seats).success(function(response) {
			if(response.errors) {
				self.errors = $scope.errorHandler(response.errors);
			} else if(response.data) {
				self.invoice.discount = response.data.percentage;
				self.invoice.discount_id = response.data.id;
				self.invoice.discount_type = "Volume";
				self.invoice.total_amount = self.invoice.sub_total - ( self.invoice.sub_total * (self.invoice.discount / 100) );
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	self.confirmCancel = function() {
		self.errors = Constants.FALSE;
		self.confirm_delete = Constants.TRUE;
		$("#cancel_subscription_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.paymentDetails = function(id, active) {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		managePrincipalPaymentService.paymentDetails(id).success(function(response) {
			if(response.errors) {
				self.errors = $scope.errorHandler(response.errors);
			} else if(response.data) {
				self.invoice = response.data;
				self.listClassroom(self.invoice.order_no);
				self.setActive(active);
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});;
	}
}