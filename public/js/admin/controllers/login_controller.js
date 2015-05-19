angular.module('futureed')
	.controller('AdminLoginController', AdminLoginController);

AdminLoginController.$inject = ['$scope', 'apiService', 'adminLoginApiService'];

function AdminLoginController($scope, apiService, adminLoginApiService){
	var vm = this;

	this.adminDoLogin = adminDoLogin;
	this.adminForgotPass = adminForgotPass;
	this.adminValidateCode = adminValidateCode;

	function adminDoLogin(){
		$scope.errors = Constants.FALSE;

		$scope.ui_block();
		adminLoginApiService.adminDoLogin(this.username, this.password).success(function(response){
			if(response.status == Constants.STATUS_OK){
				if(response.errors) {
					$scope.errorHandler(response.errors);
				}else if(response.data){
					$("#login_form input[name='user_data").val(angular.toJson(response.data));
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
		$scope.email = (!isStringNullorEmpty($scope.email)) ? $scope.email : $("#forgot_pass_form input[name='email']").val();
		this.user_type = Constants.ADMIN;

		$scope.ui_block();
		apiService.validateCode($scope.reset_code, $scope.email, this.user_type).success(function(response){
			if(response.status == Constants.STATUS_OK) {
				if(response.errors){
					$scope.errorHandler(response.errors);
				}else if(response.data){
					$("#forgot_pass_form input[name='id']").val(response.data.id);
					$("#forgot_pass_form input[name='reset_code']").val($scope.reset_code);
	          		$("#forgot_pass_form").submit();
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			$scope.internalError();
			$scope.ui_unblock();
		})

	}
}