angular.module('futureed.controllers')
	.controller('ManageInvoiceController', ManageInvoiceController);

ManageInvoiceController.$inject = ['$scope', 'ManageInvoiceService', 'apiService', 'TableService', 'SearchService'];

function ManageInvoiceController($scope, ManageInvoiceService, apiService, TableService, SearchService) {

	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setActive = function(active, invoice_no){
		self.errors = Constants.FALSE;
		self.fields = [];

		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_edit = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_VIEW:
				self.active_view = Constants.TRUE;
				break;

			case Constants.ACTIVE_EDIT:
				self.success = Constants.FALSE;
				self.active_edit = Constants.TRUE;
				break;

			case Constants.ACTIVE_LIST:
			default:
				self.success = Constants.FALSE;
				self.active_list = Constants.TRUE;
				break;
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.searchFnc = function(event) {
		self.errors = Constants.FALSE;
		self.tableDefaults();
		self.list();
		
		event = getEvent(event);
		event.preventDefault();
	}

	self.clear = function() {
		self.errors = Constants.FALSE;

		self.searchDefaults();
		self.list();
	}

	self.list = function() {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		ManageInvoiceService.list(self.search, self.table).success(function(response) {
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
			self.errors = $scope.internalError()
			$scope.ui_unblock();
		});
	}

	self.details = function(invoice_no, active) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.ui_block();
		ManageInvoiceService.details(invoice_no).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.record = response.data;
					self.record.subject_name = (self.record.invoice_detail) ? self.record.invoice_detail[0].classroom.subject.name : Constants.EMPTY_STR;
					
					var class_name = self.record.invoice_detail[0].classroom.name;
					var prefix = class_name.substring(0,3);

					self.view_student_list_link = (prefix != Constants.PREF_STU && prefix != Constants.PREF_PAR) ? Constants.TRUE:Constants.FALSE;
					self.view_students_tables = Constants.FALSE;
					self.setActive(active);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.viewAllStudents = function(id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.view_student_list_link = Constants.FALSE;

		$scope.ui_block();
		ManageInvoiceService.viewAllStudents(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.students = response.data.invoice_detail[0].classroom.class_student;
					self.view_students_tables = Constants.TRUE;
					self.back_to_order = Constants.TRUE;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.updateStatus = function() {
		self.fields = [];
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.ui_block();
		ManageInvoiceService.updateStatus(self.record).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.success = Constants.UPDATE_PAYMENT_STATUS_SUCCESS;
					self.setActive(Constants.ACTIVE_VIEW);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.getSubscriptionList = function() {
		self.errors = Constants.FALSE;
		self.subscriptions = [];

		ManageInvoiceService.getSubscriptionList().success(function(response){
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
}