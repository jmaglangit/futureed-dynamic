angular.module('futureed')
	.controller('AdminLoginController', AdminLoginController);

AdminLoginController.$inject = ['$scope', 'apiService', 'adminLoginApiService'];

function AdminLoginController($scope, apiService, adminLoginApiService){
	var self = this;

	this.adminDoLogin = adminDoLogin;
	this.adminForgotPass = adminForgotPass;
	this.adminValidateCode = adminValidateCode;
	this.adminResendCode = adminResendCode;
	this.adminResetPass = adminResetPass;

	function adminDoLogin(){
		$scope.errors = Constants.FALSE;

		$scope.ui_block();
		adminLoginApiService.adminDoLogin(self.username, self.password).success(function(response){
			if(response.status == Constants.STATUS_OK){
				if(response.errors) {
					$scope.errorHandler(response.errors);
					self.password = Constants.EMPTY_STR;
				}else if(response.data){
					$("#login_form input[name='user_data']").val(angular.toJson(response.data));
					$("#login_form").trigger(Constants.ATTR_SUBMIT);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			$scope.ui_unblock();
			$scope.internalError();
		});
	}

	function adminForgotPass(){
		$scope.$parent.errors = Constants.FALSE;
		this.user_type = Constants.ADMIN;
		this.base_url = $("#base_url_form input[name='base_url']").val();
		this.forgot_password_url = this.base_url + Constants.URL_FORGOT_PASSWORD(angular.lowercase(this.user_type));

		$scope.ui_block();
		apiService.forgotPassword(this.username, this.user_type, this.forgot_password_url).success(function(response) {
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

	function adminValidateCode(code){
		$scope.$parent.errors = Constants.FALSE;
		$scope.reset_code = code;
		$scope.email = (!isStringNullorEmpty($scope.email)) ? $scope.email : $("#redirect_form input[name='email']").val();
		this.user_type = Constants.ADMIN;

		$scope.ui_block();
		apiService.validateCode($scope.reset_code, $scope.email, this.user_type).success(function(response){
			if(response.status == Constants.STATUS_OK) {
				if(response.errors){
					$scope.errorHandler(response.errors);
				}else if(response.data){
					$("#redirect_form input[name='id']").val(response.data.id);
					$("#redirect_form input[name='reset_code']").val($scope.reset_code);
	          		$("#redirect_form").submit();
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			$scope.internalError();
			$scope.ui_unblock();
		})

	}

	function adminResendCode(){
		$scope.$parent.errors = Constants.FALSE;
		this.user_type = Constants.ADMIN;
		$scope.email = (!isStringNullorEmpty($scope.email)) ? $scope.email : $("#redirect_form input[name='email']").val();
	    this.base_url = $("#base_url_form input[name='base_url']").val();
	    this.resend_code_url = this.base_url + Constants.URL_FORGOT_PASSWORD(angular.lowercase(this.user_type));

	    $scope.ui_block();
	    apiService.resendResetCode($scope.email, this.user_type, this.resend_code_url).success(function(response){
	    	if(response.status == Constants.STATUS_OK) {
		        if(response.errors) {
		          $scope.errorHandler(response.errors);
		        } else if(response.data){
		          $scope.resent = Constants.TRUE;
		        } 
		      }
	      $scope.ui_unblock();
	    }).error(function(){
	    	$scope.internalError();
	    	$scope.ui_unblock();
	    });
	}
	function adminResetPass(){		
		self.errors = Constants.FALSE;
		$scope.r_error = Constants.FALSE;

		if(this.new_pass == this.confirm_pass){
			var reset_code = $("input[name='reset_code']").val();
	      	var id = $("input[name='id']").val();

	      	$scope.ui_block();
	      	adminLoginApiService.adminResetPass(id, reset_code, this.new_pass).success(function(response){
		      	if(response.status == Constants.STATUS_OK) {
		          if(response.errors) {
		            self.errors =  $scope.errorHandler(response.errors);
		          } else if(response.data) {
		            self.success = Constants.TRUE;
		          }
		        }

		        $scope.ui_unblock();
		      }).error(function(response) {
		        $scope.internalError();
		        $scope.ui_unblock();
		      });
		    } else {
		      self.errors = [Constants.MSG_PW_NOT_MATCH];
		      $("html, body").animate({ scrollTop: 0 }, "slow");
			}
		}
}