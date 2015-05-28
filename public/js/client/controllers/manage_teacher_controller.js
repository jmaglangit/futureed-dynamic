angular.module('futureed.controllers')
	.controller('ManageTeacherController', ManageTeacherController);

ManageTeacherController.$inject = ['$scope', 'manageTeacherService', 'apiService'];


function ManageTeacherController($scope, manageTeacherService, apiService){

	var self = this;

	self.val = {};
	self.reg = {};
	self.setActive = setActive;
	self.getTeacherList = getTeacherList;
	self.clearSearch = clearSearch;
	self.checkEmailAvailability = checkEmailAvailability;
	self.checkUsernameAvailability = checkUsernameAvailability;
	self.saveTeacher = saveTeacher;
	self.viewTeacher = viewTeacher;

	/**
	* Return Teacher List
	*/
	function getTeacherList(){

		var search_name = (self.search_name) ? self.search_name : Constants.EMPTY_STR;
		var search_email = (self.search_email) ? self.search_email : Constants.EMPTY_STR;

		$scope.ui_block();

		manageTeacherService.getTeacherList(search_name, search_email).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.data){
					self.teacherinfo = response.data.records;
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			$scope.ui_unblock();
			self.errors = $scope.internalError();
		})
	}

	function clearSearch(){
		self.search_name = Constants.EMPTY_STR;
		self.search_email = Constants.EMPTY_STR;

		self.getTeacherList();
	}

	function checkUsernameAvailability(){
		self.val.a_error = Constants.FALSE;
		self.a_success = Constants.FALSE;
		self.a_loading = Constants.TRUE;
		self.user_type = Constants.CLIENT;

		var username = self.reg.username;

		apiService.validateUsername(username, self.user_type).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.a_success = Constants.FALSE;
					self.a_loading = Constants.FALSE;
					self.val.a_error = response.errors[0].message;

					if(angular.equals(self.val.a_error, Constants.MSG_U_NOTEXIST)){
						self.val.a_error = Constants.FALSE;
						self.val.b_errors = Constants.FALSE;
						self.a_success = Constants.TRUE;
					}
				}else if(response.data){
					self.a_loading = Constants.FALSE;
					self.a_success = Constants.FALSE;
					self.val.a_error = Constants.MSG_U_EXIST;
				}
				$("html, body").animate({ scrollTop: 0 }, "slow");
			}
		}).error(function(response) {
			this.errors = $scope.internalError();
			this.a_loading = Constants.FALSE;
		});
	}

	
	function checkEmailAvailability(){
		self.val.b_errors = Constants.FALSE;
		self.b_success = Constants.FALSE;
		self.user_type = Constants.CLIENT;
		self.b_loading = Constants.TRUE;

		var email = self.reg.email;

		apiService.validateEmail(email, self.user_type).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.b_loading = Constants.FALSE;
					self.val.b_errors = response.errors[0].message;

					if(angular.equals(self.val.b_errors, Constants.MSG_EA_NOTEXIST)){
						self.val.b_errors = Constants.FALSE;
						self.val.a_error = Constants.FALSE;
						self.b_success = Constants.TRUE;
					}
				}else if(response.data){
					self.b_loading = Constants.FALSE;
					self.b_success = Constants.FALSE;
					self.val.b_errors = Constants.MSG_EA_EXIST;
				}
			}
		}).error(function(response) {
			self.b_loading = Constants.FALSE;
			self.errors = $scope.internalError();
		});
	}

	function saveTeacher(){
		self.errors = Constants.FALSE;
		var base_url = $('input[name="base_url"]').val();
		self.reg.callback_uri = base_url + '/client/register?email=' + self.reg.email;
		self.reg.current_user = $scope.user.id;

		$scope.ui_block();

		manageTeacherService.saveTeacher(self.reg).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key){
						$("#add_teacher_form input[name='" + value.field +"']" ).addClass("required-field");
					});

				}else if(response.data){
					self.errors = Constants.FALSE;
					self.is_success = Constants.Teacher + ' ' +  Constants.ADD_SUCCESS_MSG;
				}
			}
			$scope.ui_unblock();
		}).error(function(response) {
			$scope.ui_unblock();
			self.internalError();
		});

	}

	function viewTeacher(id){

		self.view_form = Constants.TRUE;
		self.view = Constants.TRUE;
		self.client_list = Constants.FALSE;

		$scope.ui_block();
		manageTeacherService.viewTeacher(id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.data){
					self.teacherdata = response.data;
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			$scope.ui_unblock();
			self.internalError();
		});
	}

	function setActive(page){

		switch(page) {

			case 'add'	:
				self.add_form = Constants.TRUE;
				self.client_list = Constants.FALSE;
				break

			case 'edit'	:
				self.add_form = Constants.FALSE;
				self.view = Constants.FALSE;
				self.teacher_save = Constants.TRUE;
				self.client_list = Constants.FALSE;
				self.edit = Constants.TRUE;
				break

			case 'list' :
			default:
				self.client_list = Constants.TRUE;
				self.add_list = Constants.FALSE;
				break
		}
		$('input, select').removeClass('required-field');
	    $("html, body").animate({ scrollTop: 0 }, "slow");			
	}
}