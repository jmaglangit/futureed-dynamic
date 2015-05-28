angular.module('futureed.controllers')
	.controller('ManageClientController', ManageClientController);

ManageClientController.$inject = ['$scope', 'apiService','manageClientService'];

function ManageClientController($scope, apiService, manageClientService) {
	var self = this;
	
	self.search = {};
	self.clients = [{}];
	self.create = {};
	self.role = {};
	self.details = {};
	self.user_type = Constants.CLIENT;
	self.schools = Constants.FALSE;

	self.getClientList = getClientList;
	self.clearSearchForm = clearSearchForm;

	self.getClientDetails = getClientDetails;
	self.rejectClient = rejectClient;
	self.verifyClient = verifyClient;

	self.clientChangeStatus = clientChangeStatus;
	self.updateClientDetails = updateClientDetails;

	self.checkEmailAvailability = checkEmailAvailability;
	self.checkUsernameAvailability = checkUsernameAvailability;
	self.setClientRole = setClientRole;
	self.searchSchool = searchSchool;
	self.selectSchool = selectSchool;

	self.createNewClient = createNewClient;

	self.setManageClientActive = setManageClientActive;
	
	function getClientList() {
		var search_name = (self.search.name) ? self.search.name: Constants.EMPTY_STR;
		var search_email = (self.search.email) ? self.search.email: Constants.EMPTY_STR;
		var search_school = (self.search.school) ? self.search.school: Constants.EMPTY_STR;
		var search_client_role = (self.search.client_role) ? self.search.client_role: Constants.EMPTY_STR;

		$scope.ui_block();
		manageClientService.getClientList(search_name, search_email, search_school, search_client_role).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.clients = (response.data.records) ? response.data.records : Constants.FALSE;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	function clearSearchForm() {
		self.errors = Constants.FALSE;
		self.search = {};
		self.getClientList();
	}

	/**
	* Get Client Details
	*/
	function getClientDetails(id) {
		self.role = {};

		$scope.ui_block();
		manageClientService.getClientDetails(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.details = response.data;
					if(angular.equals(self.details.client_role, Constants.PRINCIPAL)) {
						self.role.principal = Constants.TRUE;
					} else if(angular.equals(self.details.client_role, Constants.PARENT)) {
						self.role.parent = Constants.TRUE;
					} else if(angular.equals(self.details.client_role, Constants.TEACHER)) {
						self.role.teacher = Constants.TRUE;
					}
				}
			}

			$scope.ui_unblock();
		}).error(function() {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	function rejectClient() {
		self.base_url = $("#base_url_form input[name='base_url']").val();
	    var callback_uri = self.base_url + "/" + angular.lowercase(Constants.CLIENT) +"/registration";

		$scope.ui_block();
		manageClientService.rejectClient(self.details.id, callback_uri).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.details.rejected = Constants.TRUE;
					self.details.account_status = 'Rejected';
	    			$("html, body").animate({ scrollTop: 0 }, "slow");
				}
			}

			$scope.ui_unblock();
		}).error(function() {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	function verifyClient() {
		self.base_url = $("#base_url_form input[name='base_url']").val();
	    var callback_uri = self.base_url + "/" + angular.lowercase(Constants.CLIENT);
		
		$scope.ui_block();
		manageClientService.verifyClient(self.details.id, callback_uri).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.details.verified = Constants.TRUE;
					self.details.account_status = 'Accepted';
					$("html, body").animate({ scrollTop: 0 }, "slow");
				}
			}

			$scope.ui_unblock();
		}).error(function() {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
	
	function clientChangeStatus() {
		$scope.ui_block();
		manageClientService.clientChangeStatus(self.details.id, self.details.status).success(function(response) {
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

	function updateClientDetails() {
		self.errors = Constants.FALSE;
		self.schools = Constants.FALSE;

		if(!self.validation.s_error) {
			$("input, select").removeClass("required-field");

			$scope.ui_block();
			manageClientService.updateClientDetails(self.details).success(function(response) {
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);

						angular.forEach(response.errors, function(value) {
							$("input[name='" + value.field + "']").addClass("required-field");
							$("select[name='" + value.field + "']").addClass("required-field");
						});
					} else if(response.data) {
						self.details = {};
						self.details = response.data;
						self.setManageClientActive('view_client');
					}
				}

				$scope.ui_unblock();
			}).error(function(response) {
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			});
		} else {
			$("input[name='school_name']").addClass("required-field");
			$("html, body").animate({ scrollTop: 500 }, "slow");
		}
	}

	function checkEmailAvailability() {
		self.errors = Constants.FALSE;
		self.validation.e_loading = Constants.TRUE;
		self.validation.e_error = Constants.FALSE;
		self.validation.e_success = Constants.FALSE;

		var email = (self.create.email) ? self.create.email : self.details.email;

		apiService.validateEmail(email, self.user_type).success(function(response) {
			self.validation.e_loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.validation.e_error = response.errors[0].message;

					if(angular.equals(self.validation.e_error, Constants.MSG_EA_NOTEXIST)) {
						self.validation.e_error = Constants.FALSE;
						self.validation.e_success = Constants.TRUE;
					}
				} else if(response.data) {
					if(self.details.id != response.data.id) {
						self.validation.e_error = Constants.MSG_EA_EXIST;
					} else {
						self.validation.e_success = Constants.TRUE;
					}
				}
			}
		}).error(function(response) {
			self.validation.e_loading = Constants.FALSE;
			self.errors = $scope.internalError();
		});
	}

	function checkUsernameAvailability() {
		self.errors = Constants.FALSE;
		self.validation.u_loading = Constants.TRUE;
		self.validation.u_error = Constants.FALSE;
		self.validation.u_success = Constants.FALSE;

		var username = (self.create.username) ? self.create.username : self.details.username;

		apiService.validateUsername(username, self.user_type).success(function(response) {
			self.validation.u_loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.validation.u_error = response.errors[0].message;

					if(angular.equals(self.validation.u_error, Constants.MSG_U_NOTEXIST)) {
						self.validation.u_error = Constants.FALSE;
						self.validation.u_success = Constants.TRUE;
					}
				} else if(response.data) {
					if(self.details.id != response.data.id) {
						self.validation.u_error = Constants.MSG_U_EXIST;
					} else {
						self.validation.u_success = Constants.TRUE;
					}
				}
			}
		}).error(function(response) {
			self.validation.u_loading = Constants.FALSE;
			self.errors = $scope.internalError();
		});
	}

	function setClientRole() {
		self.role = {};

		if(angular.equals(self.create.client_role, Constants.PRINCIPAL)) {
			self.role.principal = Constants.TRUE;
		} else if(angular.equals(self.create.client_role, Constants.PARENT)) {
			self.role.parent = Constants.TRUE;
		} else if(angular.equals(self.create.client_role, Constants.TEACHER)) {
			self.role.teacher = Constants.TRUE;
		}
	}

	function searchSchool() {
		self.schools = Constants.FALSE;
		
		var school_name = '';
		
		if(self.create) {
			school_name = self.create.school_name;
			self.create.school_code = Constants.EMPTY_STR;
		} else if(self.details) {
			school_name = self.details.school_name;
			self.details.school_code = Constants.EMPTY_STR;
		}

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

	function selectSchool(school) {
		if(self.create) {
			self.create.school_code = school.code;
			self.create.school_name = school.name;
		} else if(self.details) {
			self.details.school_code = school.code;
			self.details.school_name = school.name;
		}

		self.schools = Constants.FALSE;
	}

	function createNewClient() {
		self.errors = Constants.FALSE;
		self.create.success = Constants.FALSE;

		self.base_url = $("#base_url_form input[name='base_url']").val();
		self.create.callback_uri = self.base_url + Constants.URL_USER_CREATION(angular.lowercase(Constants.CLIENT));

		$("input, select").removeClass("required-field");
		$scope.ui_block();
		manageClientService.createNewClient(self.create).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, a) {
						$("input[name='" + value.field + "'], select[name='" + value.field + "']").addClass("required-field");
					});
				} else if(response.data) {
					self.create = {};
					self.validation = {};
					self.create.success = Constants.TRUE;
	    			$("html, body").animate({ scrollTop: 0 }, "slow");
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	function setManageClientActive(active, id) {
		self.errors = Constants.FALSE;

		id = (id) ? id : self.details.id;

		self.role = {};
		self.create = {};
		self.details = {};
		self.validation = {};
		self.clients = [{}];
	
		self.schools = Constants.FALSE;

		self.active_add_client = Constants.FALSE;
		self.active_view_client = Constants.FALSE;
		self.active_edit_client = Constants.FALSE;
		self.active_client_list = Constants.FALSE;

		switch(active) {
			
			case "add_client" 	:
				self.active_add_client = Constants.TRUE;
				break;

			case "view_client"	:
				self.getClientDetails(id);
				self.active_view_client = Constants.TRUE;
				break;

			case "edit_client"	:
				self.getClientDetails(id);
				self.active_edit_client = Constants.TRUE;
				break;

			case "client_list"	:
			default:
				self.getClientList();
				self.active_client_list = Constants.TRUE;
				break
		}

		$('input, select').removeClass('required-field');
	    $("html, body").animate({ scrollTop: 0 }, "slow");
	}
}