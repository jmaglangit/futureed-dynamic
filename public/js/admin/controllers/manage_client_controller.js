angular.module('futureed.controllers')
	.controller('ManageClientController', ManageClientController);

ManageClientController.$inject = ['$scope','manageClientService', 'TableService', 'SearchService', 'ValidationService','Upload'];

function ManageClientController($scope, manageClientService, TableService, SearchService, ValidationService, Upload) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	ValidationService(self);

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.fields = [];
		self.record = {};

		self.validation = {};

		self.active_add = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_edit = Constants.FALSE;
		self.active_list = Constants.FALSE;
		self.active_import = Constants.FALSE;

		switch(active) {
			
			case Constants.ACTIVE_ADD 	:
				self.active_add = Constants.TRUE;
				break;

			case Constants.ACTIVE_IMPORT	:
				self.active_import = Constants.TRUE;
				break;

			case Constants.ACTIVE_VIEW	:
				self.active_view = Constants.TRUE;
				self.getClientDetails(id);
				break;

			case Constants.ACTIVE_EDIT	:
				self.success = Constants.FALSE;
				self.active_edit = Constants.TRUE;
				self.getClientDetails(id);
				break;

			case Constants.ACTIVE_LIST	:
			default:
				self.active_list = Constants.TRUE;
				self.getClientList();
				break
		}

		$('input, select').removeClass('required-field');
	    $("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.clearFnc = function(event) {
		event = getEvent(event);
		event.preventDefault();

		self.errors = Constants.FALSE;
		
		self.searchDefaults();
		self.tableDefaults();
		self.list();
	}

	self.searchFnc = function(event) {
		event = getEvent(event);
		event.preventDefault();

		self.errors = Constants.FALSE;

		self.tableDefaults();
		self.list();
	}

	self.list = function() {
		self.getClientList();
	}
	
	self.getClientList = function() {
		self.errors = Constants.FALSE;
		self.records = {};

		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		manageClientService.getClientList(self.search, self.table).success(function(response) {
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

	self.getClientDetails = function(id) {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		manageClientService.getClientDetails(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.record = response.data;
				}
			}

			$scope.ui_unblock();
		}).error(function() {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.rejectClient = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.base_url = $("#base_url_form input[name='base_url']").val();
	    var callback_uri = self.base_url + "/" + angular.lowercase(Constants.CLIENT) +"/registration";

		$scope.ui_block();
		manageClientService.rejectClient(self.record.id, callback_uri).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_VIEW, self.record.id);
					self.success = "Account rejected.";
				}
			}

			$scope.ui_unblock();
		}).error(function() {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.verifyClient = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.base_url = $("#base_url_form input[name='base_url']").val();
	    var callback_uri = self.base_url + "/" + angular.lowercase(Constants.CLIENT);
		
		$scope.ui_block();
		manageClientService.verifyClient(self.record.id, callback_uri).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_VIEW, self.record.id);
					self.success = "Account verified.";
				}
			}

			$scope.ui_unblock();
		}).error(function() {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
	
	self.clientChangeStatus = function() {
		$scope.ui_block();
		manageClientService.clientChangeStatus(self.record.id, self.record.user.status).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					// Status saved.
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.updateClientDetails = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.fields = [];

		self.schools = Constants.FALSE;

		//add user information
		self.record.username = self.record.user.username;
		self.record.email = self.record.user.email;
		self.record.curriculum_country = self.record.user.curriculum_country;

		//add school information
		if(self.record.school == Constants.NULL){
			self.record.school = Constants.NULL;
		} else {
			self.record.school_name = self.record.school.name;
			self.record.school_state = self.record.school.state;
			self.record.school_street_address = self.record.school.street_address;
			self.record.school_contact_name = self.record.school.contact_name;
			self.record.school_contact_number = self.record.school.contact_number;
			self.record.school_country_id = self.record.school.country_id;
		}

		if(!self.validation.s_error) {
			$scope.ui_block();
			manageClientService.updateClientDetails(self.record).success(function(response) {
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);

						angular.forEach(response.errors, function(value) {
							self.fields[value.field] = Constants.TRUE;
						});
					} else if(response.data) {
						self.setActive(Constants.ACTIVE_VIEW, self.record.id);
						self.success = Constants.MSG_UPDATED("Account");
					}
				}

				$scope.ui_unblock();
			}).error(function(response) {
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			});
		} else {
			self.fields['school_name'] = Constants.TRUE;
			$("html, body").animate({ scrollTop: 500 }, "slow");
		}
	}

	self.roleChange = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.fields = [];

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.searchSchool = function() {
		self.schools = Constants.FALSE;
		var school_name = self.record.school_name;
		self.record.school_code = Constants.EMPTY_STR;

		self.validation.s_loading = Constants.TRUE;
		self.validation.s_error = Constants.FALSE;

		manageClientService.searchSchool(school_name).success(function(response) {
			self.validation.s_loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.validation.s_error = response.errors[0].message;
				} else if(response.data) {
					self.schools = [];

					angular.forEach(response.data, function(value, key) {
						self.schools[key] = value;
					});
				}
			} 
		}).error(function(response) {
			self.errors = $scope.internalError();
			self.validation.s_loading = Constants.FALSE;
		});
	}

	self.selectSchool = function(school) {
		self.record.school_code = school.code;
		self.record.school_name = school.name;

		self.schools = Constants.FALSE;
	}

	self.add = function() {
		self.errors = Constants.FALSE;
		self.fields = [];

		self.schools = Constants.FALSE;

		self.base_url = $("#base_url_form input[name='base_url']").val();
		self.record.callback_uri = self.base_url + Constants.URL_USER_CREATION(angular.lowercase(Constants.CLIENT));

		$scope.ui_block();
		manageClientService.add(self.record).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, a) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_ADD);
					self.success = Constants.MSG_CREATED("Account");
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
	
	self.confirmDelete = function(id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.record = {};
		self.record.id = id;
		self.record.confirm = Constants.TRUE;

		$("#delete_client_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.deleteModeClient = function() {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		manageClientService.deleteModeClient(self.record.id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.setActive();
					self.success = Constants.MSG_DELETED("Account");
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.impersonate = function(user_id) {
		var data = {
			id : user_id
		}
		
		$scope.ui_block();
		manageClientService.impersonate(data).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					var data = {
						id				: response.data.id
						, user_id		: response.data.user_id
						, first_name	: response.data.first_name
						, last_name		: response.data.last_name
						, country_id	: response.data.country_id
						, role			: response.data.client_role
						, impersonate	: response.data.user.impersonate
					}

					$("#login_form input[name='user_data']").val(JSON.stringify(data));
					$("#login_form").submit();
				}
			}

			$scope.ui_unblock();
		}).error(function() {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	//download template
	self.downloadTemplate = function(data){

		$scope.ui_block();
		manageStudentService.downloadTemplate(data).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){

				}
			}
			$scope.ui_unblock();
		}).error(function() {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	//import student
	self.importFile = function(file){
		//upload file directly

		self.uploaded = Constants.FALSE;
		self.base_url = $("#base_url_form input[name='base_url']").val();
		var import_callback_uri = self.base_url + Constants.URL_USER_CREATION(angular.lowercase(Constants.CLIENT));


		var callbackUri = {
			callback_uri : 'www.google.com'
		};

		if(file.length) {
			$scope.ui_block();
			Upload.upload({
				url: '/api/v1/client/import?callback_uri=' + import_callback_uri
				, file: file[0]
			}).success(function(response) {
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);
					}else if(response.data){
						var data = response.data;
						self.upload_records = data;
						self.report_status = Constants.TRUE;

						if(data.fail_count > 0){
							self.fail_count = Constants.TRUE;
						}

						if(data.inserted_count > 0){
							self.inserted_count = Constants.TRUE;
						}
					}
				}

				$scope.ui_unblock();
			}).error(function(response) {
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			});
		}
	}
}