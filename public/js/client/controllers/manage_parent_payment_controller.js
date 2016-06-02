angular.module('futureed.controllers')
	.controller('ManageParentPaymentController', ManageParentPaymentController);

ManageParentPaymentController.$inject = ['$scope','$window', '$filter', 'ManageParentPaymentService', 'TableService', 'SearchService'];

function ManageParentPaymentController($scope, $window, $filter, ManageParentPaymentService, TableService, SearchService) {
	var self = this;
	
	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.user_id = $scope.user.id;
	self.billing_address_not_found = Constants.FALSE;

	self.checkBillingAddress = function(){
		$scope.ui_block();
		ManageParentPaymentService.checkBillingAddress(self.user_id).success(function(response) {

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					if(response.data.status == 1){
						self.billing_address_not_found = Constants.TRUE;
					}
				}
			}
			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.records = {};
		self.selected_subscription = {};
		self.students = {};
		self.validation = {};

		self.active_add = Constants.FALSE;
		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;

		//subscription
		self.active_renew = Constants.FALSE;
		self.active_pay = Constants.FALSE;
		self.active_save = Constants.FALSE;
		self.subscription_option = {};
		self.subscription_packages = {};
		self.subscription_invoice = {};
		self.subscription_views = {};
		self.subscription_continue = Constants.TRUE;
		self.subscription_discount = Constants.FALSE;

		self.getClientDetails();

		switch(active){
			case Constants.ACTIVE_ADD 	:

				self.active_add = Constants.TRUE;

				self.invoice = {};
				self.invoice.student_id = $scope.user.id;
				self.subscriptionOption();
				self.subscriptionPackage(Constants.SUBSCRIPTION_COUNTRY);
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

	self.list = function() {
		if(self.active_list) {
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
		self.tableDefaults();

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

					self.invoice = data;

					//self.getStudents(self.invoice.order_no);
					self.subscriptionView(data);
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
	self.getStudents = function(order_no) {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		ManageParentPaymentService.getStudents(order_no).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.students = response.data;
					
					if(self.invoice.subscription_id) {
						self.setSubscription();
					}
				}
			}
			
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.setSubscription = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
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
			if(angular.equals(self.invoice.payment_status, Constants.PAID)) {
					self.invoice.dis_date_start = self.invoice.date_start;
					self.invoice.dis_date_end =  self.invoice.date_end;
			} else {
				var start_date = new Date();
					self.invoice.date_start = $filter(Constants.DATE)(start_date, Constants.DATE_YYYYMMDD);
					self.invoice.dis_date_start = start_date;

				var end_date = new Date(start_date.getTime());
					end_date.setDate(end_date.getDate() + parseInt(subscription.days));

					self.invoice.date_end = $filter(Constants.DATE)(end_date, Constants.DATE_YYYYMMDD);
					self.invoice.dis_date_end = end_date;
			}	

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
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.fields = [];

		self.add.parent_id = self.user_id;
		self.add.order_id = self.invoice.order_id;
		self.add.price = (self.selected_subscription.price) ? parseInt(self.selected_subscription.price) : Constants.FALSE;
		self.add.subject_id = self.invoice.subject_id;

		$scope.ui_block();
		ManageParentPaymentService.addStudentOrderByEmail(self.add).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)) {
				self.add = {};

				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.success = [Constants.ADD_STUDENT_SUCCESS];
					self.getStudents(self.invoice.order_no);
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
		self.add.price = (self.selected_subscription.price) ? parseInt(self.selected_subscription.price) : Constants.FALSE;
		self.add.subject_id = self.invoice.subject_id;

		$scope.ui_block();
		ManageParentPaymentService.addStudentOrderByUsername(self.add).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)) {
				self.add = {};

				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.success = [Constants.ADD_STUDENT_SUCCESS];
					
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
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		var inList = Constants.TRUE;
		if(!id) {
			id = self.invoice.id;
			inList = Constants.FALSE;
		}

		$scope.ui_block();
		ManageParentPaymentService.deleteInvoice(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.success = [Constants.DELETE_INVOICE_SUCCESS];
					
					if(inList) {
						self.listPayments();
					} else {
						self.setActive();
					}
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
		self.invoice.order_date = $filter(Constants.DATE)(new Date(), Constants.DATE_YYYYMMDD);

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
		self.missing_client_credentials = Constants.FALSE;
		self.paying = Constants.TRUE;

		self.invoice.parent_id = self.user_id;
		self.invoice.order_date = $filter(Constants.DATE)(new Date(), Constants.DATE_YYYYMMDD);

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

	//TODO add payment invoice, order, and classroom then
	// TODO add students.
	self.paySubscription = function(isSave) {
		//'subject_id', 'order_date','student_id', 'subscription_id', 'date_start',
		//'date_end', 'seats_total', 'seats_taken', 'total_amount', 'payment_status','discount_id'
		//subscription_package_id

		if(self.active_view && self.invoice.renew || self.active_view){
			ManageParentPaymentService.getOrder(self.invoice.order.id).success(function(response){
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
			ManageParentPaymentService.paySubscription(self.subscription_invoice).success(function(response) {
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

	self.saveSubscription = function(){

		self.paySubscription(Constants.TRUE);
		self.setActive();

	};

	self.renewSubscription = function() {
		if(self.invoice.expired) {
			var data = {
				invoice_id	: self.invoice.id
			}

			ManageParentPaymentService.renewSubscription(data).success(function(response) {
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);
					} else if(response.data) {

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
			self.deleteInvoice(self.invoice_detail.id);	
		}
	});

	self.getPaymentUri = function(data) {

		var payment = {};
			payment.invoice_id = data.id;
			payment.quantity = Constants.TRUE;
			payment.price = data.total_amount;
			payment.client_id = data.client_id;
			payment.order_no = data.order_no;
			payment.renew = data.renew;

		var base_url = $("#base_url_form input[name='base_url']").val();
			payment.success_callback_uri = base_url + "/" + angular.lowercase(Constants.CLIENT) + "/parent/payment/success";
			payment.fail_callback_uri = base_url + "/" + angular.lowercase(Constants.CLIENT) + "/parent/payment/fail";

		ManageParentPaymentService.getPaymentUri(payment).success(function(response) {
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
					self.success = [Constants.REMOVE_STUDENT_SUCCESS];
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
	        backdrop: Constants.STATIC,
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.confirmDelete = function(id) {
		self.invoice_id = id;
		self.errors = Constants.FALSE;
		self.confirm_delete = Constants.TRUE;

		$("#invoice_modal").modal({
	        backdrop: Constants.STATIC,
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
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

	self.getClientDetails = function(){

		ManageParentPaymentService.getClient($scope.user.id).success(function (response) {
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

	//new subscription

	self.subscriptionOption = function(category,id){

		switch(category){

			case Constants.SUBSCRIPTION_COUNTRY :

				self.subscription_option.country_id = id;

				//empty values
				self.subscription_option.subject_id = Constants.FALSE;
				self.subscription_option.subscription_id = Constants.FALSE;
				self.subscription_option.days_id = Constants.FALSE;

				//next tab
				self.subscriptionPackage(Constants.SUBSCRIPTION_SUBJECT);
				navigateTab();
				break;

			case Constants.SUBSCRIPTION_SUBJECT	:

				self.subscription_option.subject_id = id;

				//empty values
				self.subscription_option.subscription_id = Constants.FALSE;
				self.subscription_option.days_id = Constants.FALSE;

				//next tab
				self.subscriptionPackage(Constants.SUBSCRIPTION_PLAN);
				navigateTab();
				break;

			case Constants.SUBSCRIPTION_PLAN	:

				self.subscription_option.subscription_id = id;

				//empty values
				self.subscription_option.days_id = Constants.FALSE;

				//next tab
				self.subscriptionPackage(Constants.SUBSCRIPTION_DAYS);
				navigateTab();
				break;

			case Constants.SUBSCRIPTION_DAYS	:

				self.subscription_option.days_id = id;

				//next tab
				self.subscriptionPackage(Constants.SUBSCRIPTION_OTHERS);

				//generate parent students
				self.getStudentList();
				navigateTab();
				break;

			case Constants.SUBSCRIPTION_STUDENTS:

				self.subscription_option.students = {};
				self.subscriptionPackage(Constants.SUBSCRIPTION_STUDENTS);
				navigateTab();
				break;

			case Constants.SUBSCRIPTION_OTHERS	:
				self.subscription_option.others = {};
				self.subscriptionPackage();

				break;
			default:
				self.subscription_option = {};
				break;
		}
	};

	self.subscriptionPackage = function(category){

		self.errors = Constants.FALSE;

		ManageParentPaymentService.subscriptionPackages(self.subscription_option).success(function(response){
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
			case Constants.SUBSCRIPTION_STUDENTS:
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

	self.subscriptionGenerateStudentList = function(){

		//Add list of students to invoice subscription
		self.subscription_invoice.students = self.enlist_student;
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

		ManageParentPaymentService.updateBillingAddress(addr_data).success(function(response){
			if(response.errors) {
				self.errors = $scope.errorHandler(response.errors);
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	};

	self.subscriptionView = function(data){

		lastTab();

		self.subscription_packages = data.subscription_package;
		self.subscription_packages.subscription = data.subscription;



		self.subscription_invoice = {
			subject_id	:	self.subscription_packages.subject_id,
			order_date	:	moment(data.order.order_date).format('YYYYMMDD'),
			date_start	:	moment(data.date_start).format('YYYYMMDD'),
			date_end	:	moment(data.date_end).format('YYYYMMDD'),
			date_start_string	:	moment(data.date_start,'YYYY-MM-DD').format('MMMM DD YYYY'),
			date_end_string	:	moment(data.date_end,'YYYY-MM-DD').format('MMMM DD YYYY'),

			students	:	[],
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

		self.generateStudentSubscriptionView(data);

		self.subscription_option = data.subscription_package;

		if(data.status == Constants.ENABLED){
			self.checkSubscription();
		}
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

		ManageParentPaymentService.subscriptionPackage(self.subscription_invoice.subscription_package_id).success(function(response){
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

		ManageParentPaymentService.getCountry(id).success(function(response){
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

		ManageParentPaymentService.getCountryList().success(function(response){

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

		ManageParentPaymentService.getClientSubscriptionDiscount(self.client_details.user_id).success(function(response){
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
			self.subscription_invoice.discount_id = (self.subscription_discount.id) ? self.subscription_discount.id : 0;

			self.generateStudentPrice();

			(self.subscription_discount.percentage) ?
				self.subscription_invoice.total_amount = subscription.price - ((subscription.price * self.subscription_discount.percentage) / 100)
				: self.subscription_invoice.total_amount = self.subscription_invoice.sub_total;

			self.subscription_invoice.subscription_package_id = subscription.id;

			//order_no,parent_id,subject_id,order_date,subscription_id,date_start,date_end,total_amount,
			//discount_type,discount_id,discount,total_amount,subscription_id,
			self.subscription_invoice.parent_id = $scope.user.id;
		}
	};

	self.generateStudentPrice = function(){

		angular.forEach(self.subscription_invoice.students,function(value){
			value.price = parseFloat(self.subscription_invoice.package_price);
			self.subscription_invoice.sub_total = self.subscription_invoice.sub_total + value.price;
		});

	}

	//get student list of the parent.
	self.getStudentList = function(){

		var data = {};

		ManageParentPaymentService.listStudents(self.client_details.id, data).success(function(response){
			if(response.errors){
				self.errors = $scope.errorHandler(response.errors);
			}else {
				self.student_list = response.data.records;
				self.enlist_student = [];
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});

	};

	self.enlistStudent = function(student){

		var index = self.enlist_student.indexOf(student);

		if (index > -1) {
			self.enlist_student.splice(index, 1);
		} else {
			self.enlist_student.push(student);
			self.enlist_student[self.enlist_student.indexOf(student)] = student;
		}
	};

	self.updateOrderDates = function(data){
		var dates = {
			date_start	: 	data.date_start,
			date_end	:	data.date_end
		};
		ManageParentPaymentService.updateOrder(data.order_id,dates).success(function(response){
			if(response.errors){
				self.errors = $scope.errorHandler(response.errors);
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}


}