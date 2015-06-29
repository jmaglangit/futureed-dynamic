angular.module('futureed.services')
	.factory('ValidationService', ValidationService);

ValidationService.$inject = ['$http', 'apiService'];

function ValidationService($http, apiService) {
	return function (scope) {
	    angular.extend(scope, {

	    	default : function() {
	    		scope.validation = {};
	    	}

			, checkUsername : function(username, user_type, is_profile) {
				self.errors = Constants.FALSE;
				self.success = Constants.FALSE;
				
				scope.validation.u_loading = Constants.TRUE;
				scope.validation.u_success = Constants.FALSE;
				scope.validation.u_error = Constants.FALSE;

				apiService.validateUsername(username, user_type).success(function(response) {
					scope.validation.u_loading = Constants.FALSE;

					if(angular.equals(response.status, Constants.STATUS_OK)) {
						if(response.errors) {
							if(angular.equals(response.errors[0].message, Constants.MSG_U_NOTEXIST)) {
								// In registration and Edit Profile
								scope.validation.u_success = Constants.MSG_U_AVAILABLE;
							} else {
								scope.validation.u_error = response.errors[0].message;
							}
						} else if(response.data) {
							if(is_profile && (response.data.id == scope.record.id)) {
								// In Edit Profile
								scope.validation.u_success = Constants.MSG_U_AVAILABLE;
							} else {
								scope.validation.u_error = Constants.MSG_U_EXIST;
							}
						}
					}
				}).error(function(response) {
					scope.validation.u_loading = Constants.FALSE;
					scope.errors = $scope.internalError();
				});
			}

			, checkEmail : function() {
				// check email
			}

			, validateCurrentEmail : function(email, current_email, user_type) {
				scope.errors = Constants.FALSE;
				scope.fields['current_email'] = Constants.FALSE;

				scope.validation.e_error = Constants.FALSE;
				scope.validation.e_success = Constants.FALSE;
				scope.validation.e_loading = Constants.TRUE;

				apiService.validateEmail(current_email, user_type).success(function(response) {
					scope.validation.e_loading = Constants.FALSE;

				    if(angular.equals(response.status, Constants.STATUS_OK)) {
				        if(response.errors) {
				            scope.validation.e_error = response.errors[0].message;
				            scope.fields['current_email'] = Constants.TRUE;
				        } else if(response.data) {
				        	if(angular.equals(email, current_email)) {
				          		scope.validation.e_success = Constants.TRUE;
				        	} else {
				        		scope.validation.e_error = Constants.MSG_EA_CURR_NOTMATCH;
				        		scope.fields['current_email'] = Constants.TRUE;
				        	}
				        }
				    }

				}).error(function(response) {
					scope.validation.e_loading = Constants.FALSE;
					scope.errors = $scope.internalError();
				});
			}

			, validateNewEmail : function(new_email, confirm_email, user_type) {
				scope.errors = Constants.FALSE;
				scope.fields['new_email'] = Constants.FALSE;
				scope.fields['confirm_email'] = Constants.FALSE;
				// Clear error messages in new email field
				scope.validation.n_error = Constants.FALSE;
				scope.validation.n_success = Constants.FALSE;
				scope.validation.n_loading = Constants.TRUE;

				// Clear error messages in confirm email field
				scope.validation.c_error = Constants.FALSE;
				scope.validation.c_success = Constants.FALSE;

				apiService.validateEmail(new_email, user_type).success(function(response) {
					scope.validation.n_loading = Constants.FALSE;

				    if(angular.equals(response.status, Constants.STATUS_OK)) {
				        if(response.errors) {
				            scope.validation.n_error = response.errors[0].message;

				            if(angular.equals(scope.validation.n_error, Constants.MSG_EA_NOTEXIST)) {
				            	scope.validation.n_error = Constants.FALSE;

				            	if(!angular.equals(new_email, confirm_email)) {
									scope.validation.n_success = Constants.TRUE;
									scope.validation.c_error = Constants.MSG_EA_CONFIRM;
									scope.fields['confirm_email'] = Constants.TRUE;
								} else {
									scope.validation.n_success = Constants.TRUE;
									scope.validation.c_success = Constants.TRUE;
								}
				            } else {
				            	scope.fields['new_email'] = Constants.TRUE;
				            }
				        } else if(response.data) {
				        	scope.validation.n_error = Constants.MSG_EA_EXIST;
				        	scope.fields['new_email'] = Constants.TRUE;
				        }
				    }

				}).error(function(response) {
					scope.validation.n_loading = Constants.FALSE;
					scope.errors = $scope.internalError();
				});
			}

			, confirmNewEmail : function(new_email, confirm_email) {
				scope.errors = Constants.FALSE;
				scope.validation.c_error = Constants.FALSE;
				scope.validation.c_success = Constants.FALSE;
				scope.fields['confirm_email'] = Constants.FALSE;
				
				if(!angular.equals(new_email, confirm_email)) {
					scope.validation.c_error = Constants.MSG_EA_NOT_MATCH;
					scope.fields['confirm_email'] = Constants.TRUE;
				} else {
					scope.validation.c_success = Constants.TRUE;
				}
			}
	    });
	};
}
