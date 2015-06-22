angular.module('futureed.services')
	.factory('ValidationService', ValidationService);

ValidationService.$inject = ['$http', 'apiService'];

function ValidationService($http, apiService) {
	return function (scope) {
	    angular.extend(scope, {

	    	default : function() {
	    		scope.validation = {};
	    	}

			, checkUsername: function(username, user_type, is_profile) {
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
					self.errors = $scope.internalError();
				});
			}

			, checkEmail: function() {
				// check email
			}
	    });
	};
}
