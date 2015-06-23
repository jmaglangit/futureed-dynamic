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

	$window.addEventListener('beforeunload', function(event) {
		managePrincipalPaymentService.cancelPayment(self.search.order_no).success(function(response) {
			console.log(response);
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
    });

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;

		self.active_list = Constants.FALSE;
		self.active_add = Constants.FALSE;

		self.tableDefaults();
		self.searchDefaults();

		switch(active) {
			case Constants.ACTIVE_ADD :
				self.fields = [];
				self.classroom = {};

				self.invoice.discount = Constants.FALSE;
				self.invoice.seats_total = Constants.FALSE;
				self.invoice.sub_total = Constants.FALSE;
				self.invoice.total_amount = Constants.FALSE;



				self.active_add = Constants.TRUE;
				break;

			case Constants.ACTIVE_LIST:
			default:
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

	self.listClassroom = function() {
		self.classrooms = [];
		self.search.order_no = self.invoice.order_no;

		$scope.ui_block();
		managePrincipalPaymentService.listClassrooms(self.search, self.table).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.classrooms = response.data.record;
					angular.forEach(self.classrooms, function(value, key) {
						value.price = Constants.FALSE;
					});

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

		self.invoice.payment_status = "Pending";
		self.invoice.invoice_date = $filter('date')(new Date(), 'yyyyMMdd');
		self.invoice.client_id = $scope.user.id;
		self.invoice.client_name = $scope.user.first_name + " " + $scope.user.last_name;

		$scope.ui_block();
		managePrincipalPaymentService.addPayment(self.invoice).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					console.log(response.data);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
	
	/**
	* Get unique order number.
	*/
	self.getOrderNo = function(callback) {
		managePrincipalPaymentService.getOrderNo($scope.user.id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.invoice.order_no = response.data;
					self.listClassroom()
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	/**
	* Get Unique invoice number
	*/
	self.getInvoiceNo = function() {
		managePrincipalPaymentService.getInvoiceNo($scope.user.id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.invoice.invoice_no = response.data;
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	self.getSchoolCode = function() {
		clientProfileApiService.getClientDetails($scope.user.id).success(function(response) {
			if(response.errors) {
				self.errors = $scope.errorHandler(response.errors);
			} else if(response.data) {
				self.classroom.school_code = response.data.school_code;
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	self.suggestTeacher = function() {
		self.errors = Constants.FALSE;

		self.classroom.client_role = Constants.TEACHER;

		managePrincipalPaymentService.getTeacherDetails(self.classroom).success(function(response) {
			// self.validation.c_loading = Constants.FALSE;
			
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if (response.errors) {
					// self.validation.c_error = response.errors[0].message;
				} else if(response.data) {
					if(response.data.length) {
						self.teachers = response.data;
					} else {
						// self.validation.c_error = "Client does not exist.";
					}
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			// self.validation.c_loading = Constants.FALSE;
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
					self.getOrderNo();

					$("html, body").animate({ scrollTop: 0 }, "slow");
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

		$scope.ui_block();
		managePrincipalPaymentService.subscriptionDetails(self.invoice.subscription_id).success(function(response) {
			if(response.errors) {
				self.errors = $scope.errorHandler(response.errors);
			} else if(response.data) {
				var subscription = response.data;

				if(subscription.price) {
					var date = moment();
					self.invoice.date_start = new Date(date).setHours(0);
					self.invoice.dis_date_start = self.invoice.date_start;
					self.invoice.date_start = $filter('date')(self.invoice.date_start, 'yyyyMMdd');

						date.add(subscription.days, 'days');

					self.invoice.date_end = new Date(date).setHours(0);
					self.invoice.dis_date_end = self.invoice.date_end;
					self.invoice.date_end = $filter('date')(self.invoice.date_end, 'yyyyMMdd');

					angular.forEach(self.classrooms, function(value, key) {
						value.price = subscription.price * value.seats_total;
						self.invoice.sub_total += value.price;
						self.invoice.seats_total += value.seats_total;
					});

					self.getDiscount();
				} else {
					angular.forEach(self.classrooms, function(value, key) {
						value.price = Constants.FALSE;
					});
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
					self.getBulkDiscount(self.invoice.total_seats);
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
}