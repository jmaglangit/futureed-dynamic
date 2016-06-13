angular.module('futureed.controllers')
	.controller('ManagePrincipalPaymentController', ManagePrincipalPaymentController);

ManagePrincipalPaymentController.$inject = ['$scope'
	, '$window'
	, '$filter'
	, 'managePrincipalPaymentService'
	, 'clientProfileApiService'
	, 'TableService'
	, 'SearchService'
	, 'apiService'];

function ManagePrincipalPaymentController(
	$scope,
	$window,
	$filter,
	managePrincipalPaymentService,
	clientProfileApiService,
	TableService,
	SearchService,
	apiService) {

	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.classroom = {};
	self.invoice = {};

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.fields = [];

		self.records = {};
		self.validation = {};

		self.active_list = Constants.FALSE;
		self.active_add = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_edit = Constants.FALSE;

		//subscription
		self.active_renew = Constants.FALSE;
		self.active_pay = Constants.FALSE;
		self.active_save = Constants.FALSE;
		self.subscription_option = {};
		self.subscription_packages = {};
		self.subscription_invoice = {};
		self.subscription_views = {};
		self.subscription_classroom = [];
		self.subscription_continue = Constants.TRUE;
		self.subscription_discount = Constants.FALSE;
		self.subscription_teacher = {};
		self.new_classroom = {};
		self.classroom_grade = Constants.FALSE;


		self.tableDefaults();
		self.searchDefaults();
		self.getClientDetails();

		switch(active) {
			case Constants.ACTIVE_VIEW:
				self.active_view = Constants.TRUE;
				lastTab();
				self.viewPayment(id);
				break;

			case Constants.ACTIVE_EDIT:
				self.active_edit = Constants.TRUE;
				break;

			case Constants.ACTIVE_ADD :
				self.classroom = {};
				self.invoice = {};

				self.invoice.discount = Constants.FALSE;
				self.invoice.seats_total = Constants.FALSE;
				self.invoice.sub_total = Constants.FALSE;
				self.invoice.total_amount = Constants.FALSE;

				self.active_add = Constants.TRUE;
				self.getSubject();

				self.subscriptionOption();
				self.subscriptionPackage(Constants.SUBSCRIPTION_COUNTRY);
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
		self.records = {};
		self.search.client_id = $scope.user.id;

		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		managePrincipalPaymentService.list(self.search, self.table).success(function(response) {
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
						self.invoice.seats_total += value.seats_total;
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

	self.savePayment = function() {
		self.addPayment(Constants.TRUE);
	}

	self.addPayment = function(save) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.invoice.invoice_date = $filter(Constants.DATE)(new Date(), Constants.DATE_YYYYMMDD);
		self.invoice.invoice_id = self.invoice.id;
		
		$scope.ui_block();
		managePrincipalPaymentService.updatePayment(self.invoice).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
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
						self.getPaymentUri();
					}
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.renewSubscription = function() {
		if(self.invoice.expired) {
			var data = {
				invoice_id	: self.invoice.id
			}

			managePrincipalPaymentService.renewSubscription(data).success(function(response) {
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);
					} else if(response.data) {

						self.invoice = response.data;
						self.invoice.subscription_id = null;
						self.setActive(Constants.ACTIVE_VIEW, response.data.id);
					}
				}

				$scope.ui_unblock();
			}).error(function(response) {
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			});
		} else {
			self.errors = $scope.internalError();
		}
	}

	$window.addEventListener('beforeunload', function() {
		if(!self.paying && self.active_add) {
			self.deleteInvoice(self.invoice.id);	
		}
	});

	self.getPaymentUri = function(data) {
		self.payment = {};
		self.payment.invoice_id = data.id;
		self.payment.quantity = Constants.TRUE;
		self.payment.price = data.total_amount;
		self.payment.client_id = data.client_id;
		self.payment.order_no = data.order_no;

		var base_url = $("#base_url_form input[name='base_url']").val();
		self.payment.success_callback_uri = base_url + "/" + angular.lowercase(Constants.CLIENT) + "/principal/payment/success"
		self.payment.fail_callback_uri = base_url + "/" + angular.lowercase(Constants.CLIENT) + "/principal/payment/fail"

		managePrincipalPaymentService.getPaymentUri(self.payment).success(function(response) {
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
		self.invoice.payment_status = Constants.PENDING;

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

	self.saveSubscription = function(){

		self.paySubscription(Constants.TRUE);
		self.setActive();

	};

	self.paySubscription = function(isSave) {
		//'subject_id', 'order_date','student_id', 'subscription_id', 'date_start',
		//'date_end', 'seats_total', 'seats_taken', 'total_amount', 'payment_status','discount_id'
		//subscription_package_id

		if(self.active_view && self.invoice.renew || self.active_view){
			managePrincipalPaymentService.getOrder(self.invoice.order.id).success(function(response){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				} else {
					var invoice = response.data;
					var order_data = {
						order_id : self.invoice.order.id,
						date_start : self.subscription_invoice.date_start,
						date_end : self.subscription_invoice.date_end
					};

					self.updateOrderDates(order_data);

					if(!isSave){
						self.getPaymentUri(invoice.invoice);
					}
				}

			}).error(function(response) {
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			});
		} else {
			$scope.ui_block();
			managePrincipalPaymentService.paySubscription(self.subscription_invoice).success(function(response) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});

					$scope.ui_unblock();
				} else if(response.data) {
					var invoice = response.data;

					if(!isSave){
						self.getPaymentUri(invoice);
					}

				}
			}).error(function(response) {
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			});
		}
	};

	self.updateOrderDates = function(data){
		var dates = {
			date_start	: 	data.date_start,
			date_end	:	data.date_end
		};
		managePrincipalPaymentService.updateOrder(data.order_id,dates).success(function(response){
			if(response.errors){
				self.errors = $scope.errorHandler(response.errors);
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.viewPayment = function(id) {
		self.errors = Constants.FALSE;
		self.client = {};

		$scope.ui_block();
		managePrincipalPaymentService.viewPayment(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {

					var data = response.data;

					self.invoice = data;

					self.subscriptionView(data);
				}
			}

			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
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
		self.classroom.client_id = Constants.EMPTY_STR;
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

		self.subscription_teacher = self.classroom;
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
		self.classroom.subject_id = self.invoice.subject_id;
		self.classroom.status = Constants.ENABLED;

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

	self.selectSubscription = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.fields = [];
		self.setPrice();
	}

	self.setPrice = function(subscription) {
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
				
				if(!angular.equals(self.invoice.payment_status, Constants.PENDING)) {
					self.invoice.dis_date_start = self.invoice.date_start;
					self.invoice.dis_date_end = self.invoice.date_end;

					angular.forEach(self.classrooms, function(value, key) {
						self.invoice.seats_total += value.seats_total;
					});

					self.invoice.sub_total = subscription.price * self.invoice.seats_total;
					self.invoice.total_amount = self.invoice.sub_total - ( self.invoice.sub_total * (self.invoice.discount / 100) );
				} else {
					if(subscription.price) {
						var start_date = new Date();
							self.invoice.date_start = $filter(Constants.DATE)(start_date, Constants.DATE_YYYYMMDD);
							self.invoice.dis_date_start = start_date;

						var end_date = new Date(start_date.getTime());
							end_date.setDate(end_date.getDate() + parseInt(subscription.days));

							self.invoice.date_end = $filter(Constants.DATE)(end_date, Constants.DATE_YYYYMMDD);
							self.invoice.dis_date_end = end_date;

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

		self.invoice.discount = Constants.FALSE;
		self.invoice.discount_id = Constants.FALSE;
		self.invoice.discount_type = Constants.CLIENT;
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
					self.invoice.discount_type = Constants.CLIENT;
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
				self.invoice.discount_type = Constants.VOLUME;
				self.invoice.total_amount = self.invoice.sub_total - ( self.invoice.sub_total * (self.invoice.discount / 100) );
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	self.confirmCancel = function(id) {
		self.errors = Constants.FALSE;
		
		self.cancel_invoice = {};
		self.cancel_invoice.id = id;
		self.cancel_invoice.confirm = Constants.TRUE;
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

				if(self.invoice.invoice_detail.length){
					self.invoice.subject_id = self.invoice.invoice_detail[0].classroom.subject.id;
					self.invoice.subject_name = self.invoice.invoice_detail[0].classroom.subject.name;
				}



				self.listClassroom(self.invoice.order_no);
				self.setActive(active,id);
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});;
	}

	self.confirmDelete = function(id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.delete_invoice = {};
		self.delete_invoice.id = id;
		self.delete_invoice.confirm = Constants.TRUE;
		$("#delete_invoice_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.cancelInvoice = function(id) {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		managePrincipalPaymentService.cancelInvoice(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.listPayments();
					self.setActive();
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.getClassroom = function(id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.ui_block();
		managePrincipalPaymentService.getClassroom(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					var data = response.data;

					self.classroom = {
						id					: data.id
						, name				: data.name
						, grade_id			: data.grade_id
						, client_name		: data.client.user.name
						, client_id			: data.client_id
						, seats_total		: data.seats_total
						, subject_id		: data.subject_id
						, update			: Constants.TRUE
					}
					
					$("html, body").animate({ scrollTop: 0 }, "slow");
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.updateClassroom = function() {
		self.errors = Constants.FALSE;
		self.fields = [];

		self.classroom.subject_id = self.invoice.subject_id;

		$scope.ui_block();
		managePrincipalPaymentService.updateClassroom(self.classroom).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.classroom = {};
					self.success = "You have successfully updated a class.";
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

	self.deleteInvoice = function(id) {
		$scope.ui_block();
		managePrincipalPaymentService.deleteInvoice(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.searchDefaults();

					self.success = Constants.DELETE_INVOICE_SUCCESS;
					self.active_add = Constants.FALSE;
					self.active_view = Constants.FALSE;
					self.active_list = Constants.TRUE;
					self.listPayments();
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.getSubject = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		managePrincipalPaymentService.getSubject().success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.subjects = response.data.records;			
				}
			}
			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	//new subscription

	self.subscriptionOption = function(category,id){

		switch(category){

			case Constants.SUBSCRIPTION_COUNTRY :

				self.subscription_option.country_id = id;

				//empty values
				self.subscription_option.subject_id = Constants.FALSE;
				self.subscription_option.subscription_id = Constants.FALSE;
				self.subscription_option.days_id = Constants.FALSE;
				disableTab();

				//next tab
				self.subscriptionPackage(Constants.SUBSCRIPTION_SUBJECT);
				navigateTab();
				break;

			case Constants.SUBSCRIPTION_SUBJECT	:

				self.subscription_option.subject_id = id;

				//empty values
				self.subscription_option.subscription_id = Constants.FALSE;
				self.subscription_option.days_id = Constants.FALSE;
				disableTab();

				//next tab
				self.subscriptionPackage(Constants.SUBSCRIPTION_PLAN);
				navigateTab();
				break;

			case Constants.SUBSCRIPTION_PLAN	:

				self.subscription_option.subscription_id = id;

				//empty values
				self.subscription_option.days_id = Constants.FALSE;
				disableTab();

				//next tab
				self.subscriptionPackage(Constants.SUBSCRIPTION_DAYS);
				navigateTab();
				break;

			case Constants.SUBSCRIPTION_DAYS	:

				self.subscription_option.days_id = id;

				//next tab
				self.subscriptionPackage(Constants.SUBSCRIPTION_OTHERS);
				disableTab();

				navigateTab();
				break;

			case Constants.SUBSCRIPTION_CLASSROOM:

				self.subscriptionPackage(Constants.SUBSCRIPTION_STUDENTS);
				disableTab();
				navigateTab();
				break;

			case Constants.SUBSCRIPTION_OTHERS	:
				self.subscription_option.others = {};
				self.subscriptionPackage();
				disableTab();

				break;
			default:
				self.subscription_option = {};
				break;
		}
	};

	self.subscriptionPackage = function(category){

		self.errors = Constants.FALSE;

		managePrincipalPaymentService.subscriptionPackages(self.subscription_option).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {

				self.subscription_packages = response.data.records;
				self.subscriptionOptionGenerator(category,self.subscription_packages);

				if(self.subscription_packages.length == Constants.TRUE){
					self.subscription_packages = self.subscription_packages[0];
				}

			}else{
				self.errors = $scope.errorHandler(response.errors);
			}

		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});

	};

	self.subscriptionOptionGenerator = function(category, data){

		self.getClientSubscriptionDiscount();
		self.getInvoice();

		switch(category){
			case Constants.SUBSCRIPTION_COUNTRY :
				self.subscriptionGenerateCountry(data);
				break;
			case Constants.SUBSCRIPTION_SUBJECT	:
				self.subscriptionGenerateSubject(data);
				break;
			case Constants.SUBSCRIPTION_PLAN	:
				self.subscriptionGeneratePlan(data);
				break;
			case Constants.SUBSCRIPTION_DAYS	:
				self.subscriptionGenerateDays(data);
				break;
			case Constants.SUBSCRIPTION_CLASSROOM:
				self.subscriptionGenerateStudentList();
				break;
			case Constants.SUBSCRIPTION_OTHERS	:
				self.subscriptionGenerateOtherInfo();
				break;
			default :
				break;
		}

	};

	self.subscriptionGenerateCountry = function(data){

		self.subscription_country = [];
		var hasCountry = 0;
		angular.forEach(data, function(value,key){
			angular.forEach(self.subscription_country,function(v,k){
				if(v.id == value.country_id){
					hasCountry = 1;
				}
			});

			if(hasCountry == 0){
				self.subscription_country.push(value.country);
			}else {
				hasCountry = 0;
			}
		});
	};

	self.subscriptionGenerateSubject = function(data){

		self.subscription_subject = [];
		var hasSubject = 0;
		angular.forEach(data, function(value,key){
			angular.forEach(self.subscription_subject,function(v,k){
				if(v.id == value.subject_id){
					hasSubject = 1;
				}
			});

			if(hasSubject == 0){
				self.subscription_subject.push(value.subject);
			}else {
				hasSubject = 0;
			}
		});
	};

	self.subscriptionGeneratePlan = function(data){

		self.subscription_plan = [];
		var hasPlan = 0;
		angular.forEach(data, function(value,key){
			angular.forEach(self.subscription_plan,function(v,k){
				if(v.id == value.subscription_id){
					hasPlan = 1;
				}
			});

			if(hasPlan == 0){
				self.subscription_plan.push(value.subscription);
			}else {
				hasPlan = 0;
			}
		});
	};

	self.subscriptionGenerateDays = function(data){

		self.subscription_days = [];
		var hasDays = 0;
		angular.forEach(data, function(value,key){
			angular.forEach(self.subscription_days,function(v,k){
				if(v.id == value.days_id){
					hasDays = 1;
				}
			});

			if(hasDays == 0){
				self.subscription_days.push(value.subscription_day);
			}else {
				hasDays = 0;
			}
		});
	};

	self.subscriptionGenerateOtherInfo = function(data){
		//get user information -- student for billing

		self.billing_information = [];


		self.billing_information.name = self.client_details.first_name + ' ' + self.client_details.last_name;
		self.billing_information.city = self.client_details.city;
		self.billing_information.state = self.client_details.state;

		//get country
		self.getCountry($scope.user.country_id);

		self.subscription_packages.others = self.billing_information;

		if(!self.billing_information.city && !self.billing_information.state && !self.billing_information.country){

			self.subscription_continue = Constants.FALSE;
		}
	};

	self.modifyUserAddress = function(data){

		//if edit == true
		if(data == Constants.TRUE){

			self.billing_info = Constants.TRUE;

		}else {

			//save new billing info
			if(self.billing_information.city && self.billing_information.state && self.billing_information.country.id){

				//update user address information.
				self.updateUserBillingInformation();
				self.subscription_continue = Constants.TRUE;
				self.billing_info = Constants.FALSE;
			};
		}
	};

	self.updateUserBillingInformation = function(){

		var addr_data = {};

		addr_data.id = $scope.user.id;
		addr_data.country_id = self.billing_information.country.id;
		addr_data.city = self.billing_information.city;
		addr_data.state = self.billing_information.state;

		managePrincipalPaymentService.updateBillingAddress(addr_data).success(function(response){
			if(response.errors) {
				self.errors = $scope.errorHandler(response.errors);
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	};

	self.generateStudentSubscriptionView = function(data){

		var students = data.invoice_detail[0].classroom.class_student;
		var subscription_package = data.subscription_package;
		var sub_total = Constants.FALSE;

		angular.forEach(students, function(value){
			value.student.price = subscription_package.price;
			sub_total += parseFloat(value.student.price);
			self.subscription_invoice.students.push(value.student);

		});

		self.subscription_invoice.sub_total = sub_total;

	}

	self.checkSubscription = function(){

		managePrincipalPaymentService.subscriptionPackage(self.subscription_invoice.subscription_package_id).success(function(response){
			if(response.errors){
				self.errors = $scope.errorHandler(response.errors);
			} else if(response.data) {
				self.active_renew = Constants.TRUE;
			} else {
				self.active_renew = Constants.FALSE;
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	};

	self.getCountry = function(id){

		managePrincipalPaymentService.getCountry(id).success(function(response){
			if(response.errors) {
				self.errors = $scope.errorHandler(response.errors);
			} else{
				self.billing_information.country =  response.data[0];
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});

	};

	self.getCountryList = function(){

		managePrincipalPaymentService.getCountryList().success(function(response){

			if(response.errors){
				self.errors = $scope.errorHandler(response.errors);
			}else {
				self.countries = response.data;
			}

		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	};

	self.getClientSubscriptionDiscount = function(){

		managePrincipalPaymentService.getClientSubscriptionDiscount(self.client_details.user_id).success(function(response){
			if(response.errors){
				self.errors = $scope.errorHandler(response.errors);
			}else if(response.data.total == Constants.TRUE) {
				self.subscription_discount = response.data.records[0];
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	};

	self.getInvoice = function(){

		//'subject_id', 'order_date','student_id', 'subscription_id', 'date_start',
		//'date_end', 'seats_total', 'seats_taken', 'total_amount', 'payment_status','discount_id'

		if (self.subscription_packages.length == 1 && self.active_add) {

			var subscription = self.subscription_packages[0];

			self.subscription_invoice.subject_id = subscription.subject_id;

			self.subscription_invoice.order_date = moment().format('YYYYMMDD');
			self.subscription_invoice.date_start = moment().format('YYYYMMDD');
			self.subscription_invoice.date_end = moment().add(subscription.subscription_day.days,'days').format('YYYYMMDD');
			self.subscription_invoice.date_start_string = moment().format('MMMM DD YYYY');
			self.subscription_invoice.date_end_string = moment().add(subscription.subscription_day.days,'days').format('MMMM DD YYYY');

			self.subscription_invoice.client_id = $scope.user.id;
			self.subscription_invoice.subscription_id = subscription.subscription_id;
			self.subscription_invoice.seats_total = (self.subscription_invoice.students) ? self.subscription_invoice.students.length : Constants.FALSE ;
			self.subscription_invoice.seats_taken = (self.subscription_invoice.students) ? self.subscription_invoice.students.length : Constants.FALSE ;
			self.subscription_invoice.payment_status = Constants.PENDING;
			self.subscription_invoice.country_id = subscription.country_id;

			self.subscription_invoice.package_price = subscription.price;
			self.subscription_invoice.sub_total = 0;
			self.subscription_invoice.discount = (self.subscription_discount.percentage) ? self.subscription_discount.percentage : 0;
			self.subscription_invoice.discount_id = self.subscription_discount.id;

			self.subscription_invoice.classrooms = self.subscription_classroom;

			self.getClassroomTotalPrice(self.subscription_invoice.classrooms);

			(self.subscription_discount.percentage) ?
				self.subscription_invoice.total_amount = self.subscription_invoice.sub_total
					- ((self.subscription_invoice.sub_total * self.subscription_discount.percentage) / 100)
				: self.subscription_invoice.total_amount = self.subscription_invoice.sub_total;

			self.subscription_invoice.subscription_package_id = subscription.id;

			//order_no,parent_id,subject_id,order_date,subscription_id,date_start,date_end,total_amount,
			//discount_type,discount_id,discount,total_amount,subscription_id,

		}
	};

	self.getClientDetails = function(){

		managePrincipalPaymentService.getClient($scope.user.id).success(function (response) {
			if (angular.equals(response.status, Constants.STATUS_OK)) {
				if (response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if (response.data) {
					var data = response.data;

					self.client_details = data;
				}
			}

		}).error(function (response) {
			self.errors = $scope.internalError();
		});
	};


	self.getClassroomGrade = function(id){

		managePrincipalPaymentService.getGrade(id).success(function (response) {
			if (angular.equals(response.status, Constants.STATUS_OK)) {
				if (response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if (response.data) {

					self.new_classroom.grade = response.data;

					self.addClassroom(self.new_classroom);
				}
			}
		}).error(function (response) {
			self.errors = $scope.internalError();
		});
	};

	self.addClassroom = function(data){

		//get grade
		var classroom = data;

		classroom.teacher = {
			'id' : self.subscription_teacher.client_id,
			'name' : self.subscription_teacher.client_name
		};

		classroom.price = (((classroom.seats) ?  classroom.seats : 0) * self.subscription_invoice.package_price);

		self.subscription_classroom.push({
			'grade': classroom.grade,
			'class_name': classroom.class_name,
			'price': classroom.price,
			'seats': classroom.seats,
			'teacher': classroom.teacher
		});

		self.new_classroom = {};
		self.subscription_teacher = {};
		self.classroom = {};
	};



	self.getGradeLevel = function(country_id) {
		self.grades = Constants.FALSE;

		apiService.getGradeLevel(country_id).success(function(response) {
			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					$scope.grades = response.data.records;
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	};

	self.removeClassroom = function(key,data){

		var index = self.subscription_classroom.indexOf(key);

		self.subscription_classroom.splice(index,1);
	};

	self.getClassroomTotalPrice = function(classrooms){

		var total_price = Constants.FALSE;

		angular.forEach(classrooms, function(value){
			total_price += value.price;
		});

		self.subscription_invoice.sub_total = total_price;
	};

	self.generateClassroom = function(data){

		self.subscription_classroom = [];

		angular.forEach(data,function(value){
			self.subscription_classroom.push({
				'grade': value.grade,
				'class_name': value.classroom.name,
				'price': value.price,
				'seats': value.classroom.seats_total,
				'teacher': value.classroom.client.user
			});
		});

	}

	self.subscriptionView = function(data){

		lastTab();

		self.subscription_packages = data.subscription_package;
		self.subscription_packages.subscription = data.subscription;

		self.generateClassroom(data.invoice_detail);

		self.subscription_invoice = {
			subject_id	:	self.subscription_packages.subject_id,
			order_date	:	moment(data.order.order_date).format('YYYYMMDD'),
			date_start	:	moment(data.date_start).format('YYYYMMDD'),
			date_end	:	moment(data.date_end).format('YYYYMMDD'),
			date_start_string	:	moment(data.date_start,'YYYY-MM-DD').format('MMMM DD YYYY'),
			date_end_string	:	moment(data.date_end,'YYYY-MM-DD').format('MMMM DD YYYY'),

			classrooms	: self.subscription_classroom,
			subscription_id	:	data.subscription_id,
			seats_total	:	data.seats_total,
			payment_status	:	data.payment_status,
			country_id	:	self.subscription_packages.country_id,

			sub_total	:	0,
			discount	:	data.discount,
			discount_id	:	data.discount_id,
			total_amount	:	data.total_amount,
			subscription_package_id	:	data.subscription_package_id
		};

		self.getClassroomTotalPrice(self.subscription_invoice.classrooms);

		self.subscription_option = data.subscription_package;

		if(data.status == Constants.ENABLED){
			self.checkSubscription();
		}
	};

}