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
	self.student_billing_address_not_found = Constants.FALSE;

	self.checkStudentBillingAddress = function() {
		$scope.ui_block();
		StudentPaymentService.checkBillingAddress(self.user_id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					if(response.data.billing_address_not_found == Constants.TRUE) {
						self.student_billing_address_not_found = Constants.TRUE;
					}
				}
			}
			$scope.ui_unblock();
		}).error(function(){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	};

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.fields = [];

		self.active_list = Constants.FALSE;
		self.active_add = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.subscription_option = {};
		self.subscription_packages = {};

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
	};

	self.searchFnc = function(event) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.tableDefaults();
		self.listPayments();
		
		event = getEvent(event);
		event.preventDefault();
	};

	self.clear = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.searchDefaults();
		self.listPayments();
	};

	self.list = function() {
		self.listPayments();
	};

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
	};

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
	};

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
	};

	self.setSubscription = function() {
		$scope.ui_block();
		StudentPaymentService.subscriptionDetails(self.invoice.subscription_id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					var subscription = response.data;
					computeDays(subscription, self.invoice);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	};

	function computeDays(subscription, record) {
		if(angular.equals(record.payment_status, Constants.PAID)) {
				self.invoice.dis_date_start = record.date_start;
				self.invoice.dis_date_end =  record.date_end;
		} else {
			var start_date = new Date();
				self.invoice.date_start = $filter('date')(start_date, 'yyyyMMdd');
				self.invoice.dis_date_start = start_date;

			var end_date = new Date(start_date.getTime());
				end_date.setDate(end_date.getDate() + parseInt(subscription.days));

				self.invoice.date_end = $filter('date')(end_date, 'yyyyMMdd');
				self.invoice.dis_date_end = end_date;
		}

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
					var invoice = response.data;
					self.getPaymentUri(invoice);
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	};

	self.saveSubscription = function() {
		self.paySubscription(Constants.TRUE);
	};

	self.paySubscription = function(save) {
		self.checkStudentBillingAddress();
		if(self.student_billing_address_not_found == Constants.FALSE) {
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
						var invoice = response.data;
						self.getPaymentUri(invoice);
					}
				}
			}).error(function(response) {
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			});
		}
	};

	self.getPaymentUri = function(invoice) {
		var payment = {};
			payment.invoice_id = invoice.invoice.id;
			payment.quantity = Constants.TRUE;
			payment.price = invoice.total_amount;
			payment.client_id = invoice.student_id;
			payment.order_no = invoice.order_no;

		var base_url = $("#base_url_form input[name='base_url']").val();
			payment.success_callback_uri = base_url + "/" + angular.lowercase(Constants.STUDENT) + "/payment/success";
			payment.fail_callback_uri = base_url + "/" + angular.lowercase(Constants.STUDENT) + "/payment/fail";

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
	};

	self.paymentDetail = function(id) {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		StudentPaymentService.paymentDetails(id).success(function(response) {
			if(response.errors) {
				self.errors = $scope.errorHandler(response.errors);
			} else if(response.data) {
				var data = response.data;

				self.invoice = {
					  id 				: 	data.id
					, payment_status	: 	data.payment_status
					, subscription_id 	: 	data.subscription_id
					, order_id 			:  	data.order.id
					, subject_id 		:  	(data.invoice_detail[0] && data.invoice_detail[0].classroom) ? data.invoice_detail[0].classroom.subject_id : Constants.EMPTY_STR
					, subject_name 		: 	(data.invoice_detail[0] && data.invoice_detail[0].classroom) ? data.invoice_detail[0].classroom.subject.name : Constants.EMPTY_STR
					, date_start 		: 	data.date_start
					, date_end 			: 	data.date_end
					, expired 			: 	data.expired
				};

				computeDays(data.subscription, self.invoice);
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	};

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
	};

	self.deleteInvoice = function(id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.ui_block();
		StudentPaymentService.deleteInvoice(id).success(function(response) {
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
	};

	self.renewPayment = function() {
		self.errors = Constants.FALSE;

		if(self.invoice.expired) {
			var data = {
				invoice_id	: self.invoice.id
			};

			StudentPaymentService.renewSubscription(data).success(function(response) {
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
				navigateTab();
				break;

				break;
			case Constants.SUBSCRIPTION_OTHERS	:
				self.subscription_option.others = {};
				self.subscriptionPackage();

				break;
			default:
				self.subscription_option = {};
				break;
		}
	}

	self.subscriptionPackage = function(category){

		self.errors = Constants.FALSE;

		StudentPaymentService.subscriptionPackage(self.subscription_option).success(function(response){
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

	}

	self.subscriptionOptionGenerator = function(category, data){

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
			case Constants.SUBSCRIPTION_OTHERS	:
				self.subscriptionGenerateOtherInfo(data);
				break;
			default :
				break;
		}

	}

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
	}

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
	}

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
	}

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
	}

	self.subscriptionGenerateOtherInfo = function(data){
		//get user information -- student for billing

		self.billing_information = [];

		self.billing_information.name = $scope.user.first_name + ' ' + $scope.user.last_name;
		self.billing_information.city = $scope.user.city;
		self.billing_information.state = $scope.user.state;

		self.getCountry($scope.user.country_id);

		self.subscription_packages.others = self.billing_information;

	}

	self.getCountry = function(id){

		StudentPaymentService.getCountry(id).success(function(response){
			if(response.errors) {
				self.errors = $scope.errorHandler(response.errors);
			} else{
				self.billing_information.country =  response.data[0];
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});

	}


}