angular.module('futureed.controllers')
	.controller('ManageClientController', ManageClientController);

ManageClientController.$inject = ['$scope', 'manageClientService'];

function ManageClientController($scope, manageClientService) {
	var self = this;
	
	self.clients = [{}];
	self.create = {};
	self.role = {};
	self.details = {};

	self.getClientList = getClientList;

	self.getClientDetails = getClientDetails;
	self.updateClientDetails = updateClientDetails;

	self.setClientRole = setClientRole;
	self.searchSchool = searchSchool;
	self.createNewClient = createNewClient;

	self.setManageClientActive = setManageClientActive;
	/**
	* List Clients
	*/
	function getClientList() {

		$scope.ui_block();
		manageClientService.getClientList().success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.clients = response.data.records;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
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

	function updateClientDetails() {
		self.errors = Constants.FALSE;

		$("input, select").removeClass("required-field");
		$scope.ui_block();
		manageClientService.updateClientDetails(self.details).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value) {
						$("input[name='" + value.field + "'], select[name='" + value.field + "']").addClass("required-field");
					});
				} else if(response.data) {
					self.details = response.data;
					self.setManageClientActive('view_client');
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
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
		manageClientService.searchSchool(self.create.school_name).success(function(response) {
			if(response.data) {
				var $school_name = $("input[name='school_name']");

			var schools = response.data[0].name;
				$(function() {
					$school_name.autocomplete({
			      		source: schools
			    	});
				});
			}
		}).error(function(response) {

		});
	}

	function createNewClient() {
		self.errors = Constants.FALSE;
		self.base_url = $("#base_url_form input[name='base_url']").val();
		self.create.callback_uri = self.base_url + Constants.URL_REGISTRATION(angular.lowercase(self.create.client_role));

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
					console.log(response.data);
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
		self.details = {};

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
				self.active_client_list = Constants.TRUE;
				break
		}

		$('input, select').removeClass('required-field');
	    $("html, body").animate({ scrollTop: 0 }, "slow");
	}
}