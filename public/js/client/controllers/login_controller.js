angular.module('futureed')
	.controller('LoginController', LoginController);

function LoginController($scope, apiService) {
	this.clientLogin = clientLogin;
	this.clientForgotPassword = clientForgotPassword;
	this.clientValidateCode = clientValidateCode;
	this.clientResendCode = clientResendCode;
	this.resetClientPassword = resetClientPassword;

	function clientLogin() {
	    $scope.errors = Constants.FALSE;

	    $scope.ui_block();
	    apiService.clientLogin(this.username, this.password, this.role).success(function(response) {
	      if(response.status == Constants.STATUS_OK) {
	        if(response.errors) {
	          $scope.errorHandler(response.errors);
	        } else if(response.data) {
	          $("#login_form input[name='user_data']").val(angular.toJson(response.data));
	          $("#login_form").trigger(Constants.ATTR_SUBMIT);
	        }
	      }

	      $scope.ui_unblock();
	    }).error(function(response) {
	      $scope.ui_unblock();
	      $scope.internalError();
	    });
	}

	function clientForgotPassword() {
		$scope.$parent.errors = Constants.FALSE;
	    this.user_type = Constants.CLIENT;

	    $scope.ui_block();
	    apiService.forgotPassword(this.username, this.user_type).success(function(response) {
	      if(response.status == Constants.STATUS_OK) {
	        if(response.errors) {
	          $scope.errorHandler(response.errors);
	        } else if(response.data){
	          $scope.email = response.data.email;
	          $scope.sent = Constants.TRUE;
	        } 
	      }

	      $scope.ui_unblock();
	    }).error(function(response) {
	      $scope.internalError();
	      $scope.ui_unblock();
	    });
	}

	function clientValidateCode(reset_code) {
		$scope.$parent.errors = Constants.FALSE;
	    $scope.reset_code = reset_code;
	    $scope.email = (!isStringNullorEmpty($scope.email)) ? $scope.email : $("#redirect_form input[name='email']").val();
	    this.user_type = Constants.CLIENT;

	    $scope.ui_block();
	    apiService.validateCode($scope.reset_code, $scope.email, this.user_type).success(function(response) {
	      if(response.status == Constants.STATUS_OK) {
	        if(response.errors) {
	          $scope.errorHandler(response.errors);
	        } else if(response.data){
	          $("#redirect_form input[name='id']").val(response.data.id);
          	  $("#redirect_form input[name='reset_code']").val($scope.reset_code);
	          $("#redirect_form").submit();
	        } 
	      }

	      $scope.ui_unblock();
	    }).error(function(response) {
	      $scope.internalError();
	      $scope.ui_unblock();
	    });
	}

	function clientResendCode() {
	    $scope.$parent.errors = Constants.FALSE;
	    this.user_type = Constants.CLIENT;
	    $scope.email = (!isStringNullorEmpty($scope.email)) ? $scope.email : $("#redirect_form input[name='email']").val(); 

	    $scope.ui_block();
	    apiService.resendResetCode($scope.email, this.user_type).success(function(response) {
	      if(response.status == Constants.STATUS_OK) {
	        if(response.errors) {
	          $scope.errorHandler(response.errors);
	        } else if(response.data){
	          $scope.resent = Constants.TRUE;
	        } 
	      }

	      $scope.ui_unblock();
	    }).error(function(response) {
	      $scope.internalError();
	      $scope.ui_unblock();
	    });
	}

	function resetClientPassword() {
	    $scope.$parent.errors = Constants.FALSE;

	    if(this.new_password == this.confirm_password) {
	      var reset_code = $("input[name='reset_code']").val();
	      var id = $("input[name='id']").val();

	      $scope.ui_block();
	      apiService.resetClientPassword(id, reset_code, this.new_password).success(function(response) {
	        if(response.status == Constants.STATUS_OK) {
	          if(response.errors) {
	            $scope.errorHandler(response.errors);
	          } else if(response.data) {
	            $scope.$parent.success = Constants.TRUE;
	          }
	        }

	        $scope.ui_unblock();
	      }).error(function(response) {
	        $scope.internalError();
	        $scope.ui_unblock();
	      });
	    } else {
	      $scope.$parent.errors = [Constants.Constants.MSG_PW_NOT_MATCH];
	      $("html, body").animate({ scrollTop: 0 }, "slow");
	    }
	}

}

LoginController.$inject = ['$scope', 'apiService'];

	