angular.module('futureed.controllers')
	.controller('StudentLoginController', StudentLoginController);

StudentLoginController.$inject = ['$scope', '$filter', '$controller', '$window', 'StudentLoginService', 'MediaLoginService'];

function StudentLoginController($scope, $filter, $controller, $window, StudentLoginService, MediaLoginService) {
	var self = this;

	angular.extend(self, $controller('MediaLoginController', { $scope : $scope}));

	self.fbAsyncInit();

	self.setActive = function(active) {
		self.errors = Constants.FALSE;
		self.record = Constants.FALSE;

		self.active_login = Constants.FALSE;
		self.active_confirm = Constants.FALSE;
		self.active_enter_password = Constants.FALSE;

		switch(active) {
			case 'confirm_media'	:
				self.active_confirm = Constants.TRUE;
				break;

			case 'confirm_success'	:
				self.active_confirm_success = Constants.TRUE;
				break;

			case 'enter_password'	:
				self.active_enter_password = Constants.TRUE;
				break;

			case 'login'			:

			default					:
				self.active_login = Constants.TRUE;
				break;
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.setActive();

	$scope.$on('confirm-media', checkMediaLogin);

	function checkMediaLogin(event, data) {
		if(data.confirm) {
			self.setActive('confirm_media');

			if(angular.equals(data.media_type, Constants.GOOGLE)) {

				self.getGoogleDetails(function(response) {
					self.record = data;
					self.record.first_name = response.given_name;
					self.record.last_name = response.family_name;

					$scope.$apply();
				});
			} else {
				self.record = data;
			}
		}
	}

	self.confirmMediaDetails = function() {
		self.errors = Constants.FALSE;
		self.fields = [];

		if(!self.record.terms) {
			self.errors = ["Please accept the terms and conditions."];
			$("html, body").animate({ scrollTop: 0 }, "slow");
			return;
		}

		$("div.birth-date-wrapper select").removeClass("required-field");

		var birth_date = $("input#birth_date").val();
			self.record.birth_date = $filter(Constants.DATE)(new Date(birth_date), Constants.DATE_YYYYMMDD);

		$scope.ui_block();
		MediaLoginService.registerMedia(self.record, angular.lowercase(self.record.media_type)).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});

					if(self.fields['birth_date']) {
						$("div.birth-date-wrapper select").addClass("required-field");
					}
				} else if(response.data){
					self.record = response.data;
					self.setActive('confirm_success');
				} 
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.proceedToDashboard = function() {
		$scope.user = JSON.stringify(self.record);
		$("input[name='user_data']").val(JSON.stringify(self.record));
		$("#media_form").submit();
	}

	function showModal(id) {
		self.show_terms = (id == 'terms_modal') ? Constants.TRUE : Constants.FALSE;
		self.show_policy = (id == 'policy_modal') ? Constants.TRUE : Constants.FALSE;
		self.show = Constants.TRUE;


		$("#"+id).modal({
				backdrop: 'static',
				keyboard: Constants.FALSE,
				show    : Constants.TRUE
		});
	}

	self.setDropdown = function (date) {
		var options = {
			submitFieldName: 'birth_date'
			, wrapperClass: 'birth-date-wrapper'
			, minAge: Constants.MIN_AGE
			, maxAge: Constants.MAX_AGE
		}

		if(date) {
			options.defaultDate = date;
		}

		$("#birth_date").dateDropdowns(options);
	}



	// Manual Login

	/**
	* Validate Student Email Address / Username
	* 
	* @Params 
	*   username - the username
	*/
	self.manual = {};

	self.validateUser = function(event) {
		event = getEvent(event);
		event.preventDefault();
		
		$scope.errors = Constants.FALSE;

		$scope.ui_block();
		StudentLoginService.validateUser(self.manual.username).success(function(response) {
			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
					self.manual.id = response.data.id;
					$scope.getLoginPassword(self.manual.id);
					self.setActive('enter_password');
				} 
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.cancelLogin = function() {
		self.errors = Constants.FALSE;
		self.manual = {};
		self.setActive();
	}

	self.selectPassword = function(event) {
			$scope.highlight(event);
			self.validatePassword();
	}

	/**
	* Validate Selected Image Password
	* 
	* @Params 
	*   id        - the student id
	*   image_id  - selected image password
	*/
	self.validatePassword = function() {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		StudentLoginService.validatePassword(self.manual.id, $scope.image_id).success(function(response) {
			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
					$scope.image_pass = shuffle($scope.image_pass);
				} else if(response.data){
					$scope.user = JSON.stringify(response.data);
					$("input[name='user_data']").val(JSON.stringify(response.data));
					$("#media_form").submit();
				} 
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	} 
}