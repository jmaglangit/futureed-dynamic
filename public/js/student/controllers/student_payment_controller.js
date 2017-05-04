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
		self.active_renew = Constants.FALSE;
		self.active_pay = Constants.FALSE;
		self.active_save = Constants.FALSE;
		self.subscription_option = {};
		self.subscription_packages = {};
		self.subscription_invoice = {};
		self.subscription_views = {};
		self.subscription_continue = Constants.TRUE;
		self.subscription_discount = Constants.FALSE;
		self.user_curr_country = Constants.FALSE;

		//get curriculum country
		self.getCurriculumCountry();

		switch(active) {
			case Constants.ACTIVE_ADD 	:
				self.active_add = Constants.TRUE;

				self.invoice = {};
				self.invoice.student_id = $scope.user.id;
				self.subscriptionOption();
				self.subscriptionPackage(Constants.SUBSCRIPTION_COUNTRY);
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

	// invoice_update (optional parameter to update student payment)
	self.updateSubscription = function(save, invoice_update = Constants.FALSE) {
		self.fields = [];
		self.errors = Constants.FALSE;
		var invoice = self.invoice;

		if(!invoice_update) {
			self.invoice.order_date = $filter('date')(new Date(), 'yyyyMMdd');
			self.invoice.student_id = $scope.user.id;
		} else {
			invoice = invoice_update;
			invoice.order_date = $filter('date')(new Date(), 'yyyyMMdd');
			invoice.student_id = $scope.user.id;
		}

		$scope.ui_block();
		StudentPaymentService.updateSubscription(invoice).success(function(response) {
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
		$scope.ui_block();

		StudentPaymentService.saveSubscription(self.subscription_invoice).success(function(response) {
			if(response.errors) {
				self.errors = $scope.errorHandler(response.errors);
			} else {
				self.setActive();
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	};

	self.paySubscription = function() {
		//'subject_id', 'order_date','student_id', 'subscription_id', 'date_start',
		//'date_end', 'seats_total', 'seats_taken', 'total_amount', 'payment_status','discount_id'
		//subscription_package_id

		if(self.active_view && self.invoice.renew || self.active_view){
			StudentPaymentService.getOrder(self.invoice.order.id).success(function(response){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				} else {
					var invoice = response.data;
					var order_data = {
						order_id : self.invoice.order.id,
						date_start : self.subscription_invoice.date_start,
						date_end : self.subscription_invoice.date_end
					};

					if(angular.equals(self.invoice.payment_status, Constants.PENDING)) {
						var invoice_update = {
							order_id        : self.invoice.order.id,
							subject_id      : self.invoice.invoice_detail[0].classroom.subject_id,
							order_date      : self.invoice.order_date,
							student_id      : self.invoice.student_id,
							subscription_id : self.invoice.subscription_id,
							date_start      : moment(self.invoice.date_start).format('YYYYMMDD'),
							date_end        : moment(self.invoice.date_end).format('YYYYMMDD'),
							seats_total     : self.invoice.seats_total,
							seats_taken     : Constants.TRUE,
							total_amount    : self.invoice.total_amount,
							payment_status  : self.invoice.payment_status
						};

						self.updateSubscription(Constants.FALSE, invoice_update);
					}

					self.updateOrderDates(order_data);
					self.getPaymentUri(invoice);
				}

			}).error(function(response) {
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			});
		} else {
			$scope.ui_block();
			StudentPaymentService.paySubscription(self.subscription_invoice).success(function(response) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});

					$scope.ui_unblock();
				} else if(response.data) {
						var invoice = response.data;
						self.getPaymentUri(invoice);

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

		if(payment.price > Constants.FALSE){
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
		} else {
			$window.location.href = payment.success_callback_uri;
		}

	};

	self.paymentDetail = function(id) {

		//1. get to subscribe view and disable the rest of the options.
		//if renewable enable button.
		//disable other tabs.
		self.errors = Constants.FALSE;

		$scope.ui_block();
		StudentPaymentService.paymentDetails(id).success(function(response) {
			if(response.errors) {
				self.errors = $scope.errorHandler(response.errors);
			} else if(response.data) {
				var data = response.data;

				self.invoice = data;
				self.subscriptionView(response.data);

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

		StudentPaymentService.subscriptionPackages(self.subscription_option).success(function(response){
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

		self.getStudentDiscount();
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

			if(hasCountry == 0 && self.user_curr_country == Constants.FALSE){
				self.subscription_country.push(value.country);
			}else {
				hasCountry = 0;
			}

			if(self.user_curr_country == value.country.id){
				self.subscription_country = [];
				self.subscription_country.push(value.country);
				self.subscription_option.country_id = value.country.id;
				self.has_curr_country = Constants.TRUE;
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

		self.billing_information.name = $scope.user.first_name + ' ' + $scope.user.last_name;
		self.billing_information.city = $scope.user.city;
		self.billing_information.state = $scope.user.state;

		if($scope.user.country_id != Constants.NULL){

			self.getCountry($scope.user.country_id);
		}

		self.subscription_packages.others = self.billing_information;

		if(!self.billing_information.city && !self.billing_information.state && !self.billing_information.country){

			self.subscription_continue = Constants.FALSE;
		}

	};

	self.getCountry = function(id){

		StudentPaymentService.getCountry(id).success(function(response){
			if(!response.errors) {
				self.billing_information.country =  response.data[0];
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});

	};

	self.getCountryList = function(){

		StudentPaymentService.getCountryList().success(function(response){

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

	self.modifyUserAddress = function(data){

		//if edit == true
		if(data == Constants.TRUE){

			self.billing_info = Constants.TRUE;
			self.subscription_continue = Constants.FALSE;

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

		StudentPaymentService.updateStudentAddress(addr_data).success(function(response){
			if(response.errors){
				self.errors = $scope.errorHandler(response.errors);
			}else {

				self.getCountry(self.billing_information.country.id);
				$scope.user.city = self.billing_information.city;
				$scope.user.state = self.billing_information.state;
				$scope.user.country_id = self.billing_information.country.id;
				$scope.user.country = self.billing_information.country;

				apiService.updateUserSession($scope.user).success(function(response) {
					if(response.errors){
						self.errors = $scope.errorHandler(response.errors);
					}
				}).error(function() {
					$scope.internalError();
				});
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	};

	self.getStudentDiscount = function(){

		StudentPaymentService.getClientDiscount($scope.user.user.id).success(function(response){
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
			self.subscription_invoice.order_date_string = moment().format('DD/MM/YYY');
			self.subscription_invoice.date_end = subscription.subscription_day.days;
			self.subscription_invoice.date_start_string = moment().format('MMMM DD YYYY');
			self.subscription_invoice.date_end_string = moment().add(subscription.subscription_day.days,'days').format('MMMM DD YYYY');

			self.subscription_invoice.student_id = $scope.user.id;
			self.subscription_invoice.subscription_id = subscription.subscription_id;
			self.subscription_invoice.seats_total = Constants.TRUE;
			self.subscription_invoice.seats_taken = Constants.TRUE;
			self.subscription_invoice.payment_status = Constants.PENDING;
			self.subscription_invoice.country_id = subscription.country_id;

			self.subscription_invoice.sub_total = subscription.price;
			self.subscription_invoice.discount = (self.subscription_discount.percentage) ? self.subscription_discount.percentage : 0;
			self.subscription_invoice.discount_id = self.subscription_discount.id;
			self.subscription_invoice.total_amount = subscription.price - ((subscription.price * self.subscription_invoice.discount) / 100);
			self.subscription_invoice.subscription_package_id = subscription.id;

		}
	};

	self.subscriptionView = function(data){

		lastTab();

		self.subscription_packages = data.subscription_package;
		self.subscription_packages.subscription = data.subscription;

		self.subscription_invoice = {
			subject_id	:	self.subscription_packages.subject_id,
			order_date	:	moment(data.order.order_date).format('YYYYMMDD'),
			order_date_string : moment(data.order.order_date).format('DD/MM/YYYY'),
			date_start	:	moment(data.date_start).format('YYYYMMDD'),
			date_end	:	moment(data.date_end).format('YYYYMMDD'),
			date_start_string	:	moment(data.date_start,'YYYY-MM-DD').format('MMMM DD, YYYY'),
			date_end_string	:	moment(data.date_end,'YYYY-MM-DD').format('MMMM DD, YYYY'),

			student_id	:	$scope.user.id,
			subscription_id	:	data.subscription_id,
			seats_total	:	data.seats_total,
			payment_status	:	data.payment_status,
			country_id	:	self.subscription_packages.country_id,

			sub_total	:	data.subscription_package,
			discount	:	data.discount,
			discount_id	:	data.discount_id,
			total_amount	:	data.total_amount,
			subscription_package_id	:	data.subscription_package_id

		};

		self.subscription_option = data.subscription_package;

		if(data.status == Constants.ENABLED){
			self.checkSubscription();
		}
	};

	self.renewSubscription = function(){

		var invoice = self.invoice;

		//check subscription package is still exists else output error to get new subscription.
		//update date views.

		self.checkSubscription();

		//extend date

		self.subscription_invoice.order_date = moment().format('YYYYMMDD');
		self.subscription_invoice.date_start = moment().format('YYYYMMDD');
		self.subscription_invoice.date_end = moment().add(self.subscription_packages.subscription_day.days,'days').format('YYYYMMDD');
		self.subscription_invoice.date_start_string = moment().format('MMMM DD YYYY');
		self.subscription_invoice.date_end_string = moment().add(self.subscription_packages.subscription_day.days,'days').format('MMMM DD YYYY');


		//enable button
		self.active_pay = Constants.TRUE;

	};

	self.checkSubscription = function(){

		StudentPaymentService.subscriptionPackage(self.subscription_invoice.subscription_package_id).success(function(response){
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
	}

	self.updateOrderDates = function(data){
		var dates = {
			date_start	: 	data.date_start,
			date_end	:	data.date_end
		};
		StudentPaymentService.updateOrder(data.order_id,dates).success(function(response){
			if(response.errors){
				self.errors = $scope.errorHandler(response.errors);
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	//get latest curriculum country
	self.getCurriculumCountry = function(){

		StudentPaymentService.getCurriculumCountry($scope.user.user.id).success(function(response){
			if(response.errors){
				self.errors = $scope.errorHandler(response.errors);
			}

			self.user_curr_country = response.data;

		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.updateBackground = function() {
		$("footer").css('background-image', 'none');

		StudentPaymentService.getStudentBackgroundImage($scope.user.user.id).success(function(response){
			if(response.data){
				angular.element('body.student').css({
					'background-image' : 'url("' + response.data.url + '")'
				});
			}else{
				angular.element('body.student').css({
					'background-image' : 'url("/images/class-student/mountain-full-bg.png")'
				});
			}
		}).error(function(response){
			self.error = $scope.internalError();
		});
	}

}