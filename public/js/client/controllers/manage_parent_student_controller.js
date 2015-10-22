angular.module('futureed.controllers')
	.controller('ManageParentStudentController', ManageParentStudentController);

ManageParentStudentController.$inject = ['$scope', '$filter', 'ManageParentStudentService', 'TableService', 'SearchService', 'ValidationService','apiService'];

function ManageParentStudentController($scope, $filter, ManageParentStudentService, TableService, SearchService, ValidationService, apiService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	ValidationService(self);
	self.default();
	
	self.user_type = Constants.STUDENT;

	self.existActive = function() {
		self.record = {};
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$("#birth_date").dateDropdowns({
		    submitFieldName: 'birth_date',
		    wrapperClass : 'birth-date-wrapper',
		    minAge: Constants.MIN_AGE,
		    maxAge: Constants.MAX_AGE
		});

		$('input, select').removeClass('required-field');
	}

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.fields = [];

		self.record = {};
		self.validation = {};
		
		self.active_list = Constants.FALSE;
		self.active_add = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_edit = Constants.FALSE;
		self.active_invite = Constants.FALSE;
		self.active_change = Constants.FALSE;
		
		switch(active) {
			case Constants.ACTIVE_EDIT:
				self.active_edit = Constants.TRUE;
				self.viewStudent(id);
				break;

			case 'change':
				self.change = {};
				self.active_change = Constants.TRUE;
				break;

			case Constants.ACTIVE_ADD:
				self.active_add = Constants.TRUE;
				self.exist = Constants.TRUE;
				break;

			case 'invite':
				self.active_invite = Constants.TRUE;
				break;

			case Constants.ACTIVE_VIEW:
				self.active_view = Constants.TRUE;
				self.viewStudent(id);
				break;

			case Constants.ACTIVE_LIST:
				self.list();
			
			default :
				self.active_list = Constants.TRUE;
				break;
		}

		$('input, select').removeClass('required-field');
		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.searchFnc = function(event) {
		self.tableDefaults();
		self.list();

		event = getEvent(event);
		event.preventDefault();
	}

	self.clear = function() {
		self.searchDefaults();
		self.tableDefaults();
		
		self.list();
	}

	self.list = function() {
		if(self.active_list) {
			self.getStudentlist();
		}
	}

	self.getStudentlist = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.records = {};

		self.search.client_id = $scope.user.id;
		self.table.loading = Constants.TRUE;
		
		$scope.ui_block();
		ManageParentStudentService.getStudentlist(self.search, self.table).success(function(response){
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.records = response.data.records;
					self.updatePageCount(response.data);
				}
			}
			
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			self.table.loading = Constants.FALSE;
			$scope.ui_unblock();
		});
	}

	self.addExist = function(event) {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		ManageParentStudentService.addExist(self.record.email_exist, $scope.user.id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data){
					self.setActive('invite');
				}
			}

			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});

		event = getEvent(event);
		event.preventDefault();
	}

	self.submitCode = function(event) {
		event = getEvent(event);
		event.preventDefault();

		self.errors = Constants.FALSE;
		self.fields = [];

		$scope.ui_block();
		ManageParentStudentService.submitCode($scope.user.id, self.record.invitation_code).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});
				}else if(response.data) {
					self.success = Constants.STUDENT + ' ' + Constants.ADD_SUCCESS_MSG;
					
					if(self.record.id) {
						self.setActive(Constants.ACTIVE_VIEW, self.record.id);
					} else {
						self.setActive(Constants.ACTIVE_LIST);
					}
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.addStudent = function(event) {
		self.fields = [];
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.record.client_id = $scope.user.id;

		$("div.birth-date-wrapper select").removeClass("required-field");

		var bdate = $("input#birth_date").val();
		self.record.birth_date = $filter(Constants.DATE)(new Date(bdate), Constants.DATE_YYYYMMDD)

		var base_url = $("#base_url_form input[name='base_url']").val();
		self.record.callback_uri = base_url + Constants.URL_REGISTRATION(angular.lowercase(Constants.STUDENT));

		$scope.ui_block();
		ManageParentStudentService.addStudent(self.record).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
		            });

		            if(self.fields['birth_date']) {
		            	$("div.birth-date-wrapper select").addClass("required-field");
		            }
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_ADD);
					self.exist = Constants.FALSE;
					self.success = Constants.MSG_CREATED("Student account");

					$("div.birth-date-wrapper select").val(Constants.EMPTY_STR);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});

		event = getEvent(event);
		event.preventDefault();

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.viewStudent = function(id) {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		ManageParentStudentService.viewStudent(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					var data = response.data;

					self.record = response.data;
					self.record.email = data.user.email;
					self.record.username = data.user.username;
					self.record.new_email = data.user.new_email;

					self.dateDropdown(self.record.birth_date);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.saveStudent = function() {
		self.fields = [];
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$("div.birth-date-wrapper select").removeClass("required-field");

		var birth_date = $("#student_form #birth_date").val();
		self.record.birth_date = $filter(Constants.DATE)(new Date(birth_date), Constants.DATE_YYYYMMDD);

		$scope.ui_block();
		ManageParentStudentService.saveStudent(self.record).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
		            });

		            if(self.fields['birth_date']) {
		            	$("div.birth-date-wrapper select").addClass("required-field");
		            }
				}else if(response.data) {
					self.setActive(Constants.ACTIVE_VIEW, self.record.id);
					self.success = Constants.MSG_UPDATED("Student account");
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			$scope.internalError();
			$scope.ui_unblock();
		});

	}
	self.changeEmail = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.fields = [];
		
		self.change.id = self.record.id;
		self.change.client_id = $scope.user.id;
		self.change.email = self.change.current_email;

		var base_url = $("#base_url_form input[name='base_url']").val();
		self.change.callback_uri = base_url + Constants.URL_CHANGE_EMAIL(angular.lowercase(Constants.STUDENT));

		$scope.ui_block();
		ManageParentStudentService.changeEmail(self.change).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_VIEW, self.record.id);
					self.success = Constants.MSG_UPDATED("Email address");
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.playStudent = function(id) {
		$scope.ui_block();
		var data = {
			id: id
			, user_type: Constants.CLIENT
		}

		apiService.logout(data).success(function (response) {
			if (angular.equals(response.status, Constants.STATUS_OK)) {
				if (response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if (response.data) {

					ManageParentStudentService.playStudent().success(function (response) {
						if (angular.equals(response.status, Constants.STATUS_OK)) {
							$("#redirect_form input[name='id']").val(id);
							$("#redirect_form").submit();
						}

						$scope.ui_unblock();
					}).error(function () {
						self.errors = $scope.internalError();
						$scope.ui_unblock();
					})
				}
			}

			$scope.ui_unblock();
		}).error(function () {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.dateDropdown = function(date) {
		$("#birth_date").dateDropdowns({
			defaultDate : date,
		    submitFieldName: 'birth_date',
		    wrapperClass: 'birth-date-wrapper',
		    minAge: Constants.MIN_AGE,
		    maxAge: Constants.MAX_AGE
		});

		if(self.active_edit) {
			$(".day, .month, .year").prop('disabled', false);
		}else {
			$(".day, .month, .year").prop('disabled', true);
		}
	}
}