angular.module('futureed')
	.controller('ProfileController', ProfileController);


LoginController.$inject = ['$scope', 'apiService', 'clientProfileApiService'];

function ProfileController($scope, apiService, clientProfileApiService) {
	var self = this;
	this.change = {};

	this.setClientProfileActive = setClientProfileActive;
	this.getClientDetails = getClientDetails;
	this.saveClientProfile = saveClientProfile;
	this.changeClientPassword = changeClientPassword;

	function setClientProfileActive(active) {
	    self.errors = Constants.FALSE;
	    $scope.$parent.u_error = Constants.FALSE;
		$scope.$parent.u_success = Constants.FALSE;

	    switch(active) {
	      case Constants.PASSWORD :
	      	self.active_password = Constants.TRUE;
	      	self.password_changed = Constants.FALSE;
	      	self.active_index = Constants.FALSE;
	      	self.active_edit = Constants.FALSE;
	        break;

	      case Constants.EDIT:
	      	self.getClientDetails();
	      	self.active_index = Constants.FALSE;
	      	self.active_password = Constants.FALSE;
	      	self.active_edit = Constants.TRUE;
	      	
		    self.errors = Constants.FALSE;
		    self.success = Constants.FALSE;
	      	break;

	      case Constants.INDEX    :
	      default:
	        self.getClientDetails();
	        self.active_index = Constants.TRUE;
	        self.active_password = Constants.FALSE;
	        self.active_edit = Constants.FALSE;
	        break;
	    }

	    $('input, select').removeClass('required-field');
	    $("html, body").animate({ scrollTop: 0 }, "slow");
	}

	function getClientDetails() {
		clientProfileApiService.getClientDetails($scope.user.id).success(function(response) {
			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
					$scope.errorHandler(response.errors);
				} else if(response.data) {
					self.prof = response.data;

					if(angular.equals(self.prof.client_role, Constants.PRINCIPAL)) {
						self.is_principal = Constants.TRUE;
					} else if(angular.equals(self.prof.client_role, Constants.PARENT)) {
						self.is_parent = Constants.TRUE;
						self.is_required = Constants.TRUE;
					} else if(angular.equals(self.prof.client_role, Constants.TEACHER)) {
						self.is_teacher = Constants.TRUE;
					}
				}
			}
		}).error(function(response) {
			$scope.internalError();
		});
	}

	function saveClientProfile() {
		self.errors = Constants.FALSE;

		if($scope.u_error) {
			$("html, body").animate({ scrollTop: 0 }, "slow");
		} else {
			$scope.$parent.u_error = Constants.FALSE;
			$scope.$parent.u_success = Constants.FALSE;
			$('input, select').removeClass('required-field');

			$scope.ui_block();
			clientProfileApiService.saveClientProfile(self.prof).success(function(response) {
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);

						angular.forEach(response.errors, function(value, key) {
			              $("#client_profile_form input[name='" + value.field +"']").addClass("required-field");
			              $("#client_profile_form select[name='" + value.field +"']").addClass("required-field");
			            });
					} else if(response.data) {
						$scope.$parent.user = response.data;

						apiService.updateUserSession(response.data).success(function(response) {
			              self.setClientProfileActive(Constants.INDEX);
			              self.success = Constants.TRUE;
			            }).error(function() {
			              $scope.internalError();
			            });
					}
				}

				$scope.ui_unblock();
			}).error(function(response) {
				$scope.internalError();
				$scope.ui_unblock();
			});
		}
	}

	function changeClientPassword() {
		self.errors = Constants.FALSE;
		$("#client_change_pass_form input").removeClass("required-field");

		if(angular.equals(self.change.new_password, self.change.confirm_password)) {
			$scope.ui_block();
			clientProfileApiService.changeClientPassword($scope.user.id, self.change).success(function(response) {
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);

						angular.forEach(response.errors, function(value, key) {
			              $("#client_change_pass_form input[name='" + value.field +"']").addClass("required-field");
			            });
						client_change_pass_form
					} else if(response.data) {
						self.password_changed = Constants.TRUE;
						self.change = {};
					}
				} 

				$scope.ui_unblock();
			}).error(function(response) {
				$scope.internalError();
				$scope.ui_unblock();
			});
		} else {
			self.errors = [Constants.MSG_PW_NOT_MATCH];
			$("#client_change_pass_form input[name='new_password']").addClass("required-field");
			$("#client_change_pass_form input[name='confirm_password']").addClass("required-field");
		}
	}
}