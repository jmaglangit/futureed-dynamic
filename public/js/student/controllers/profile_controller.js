angular.module('futureed.controllers')
	.controller('ProfileController', ProfileController);

ProfileController.$inject = ['$scope', 'apiService'];

function ProfileController($scope, apiService) {
	var self = this;

	self.user = (sessionStorage.length) ? JSON.parse(sessionStorage.user) : {};
	self.setStudentProfileActive = setStudentProfileActive;

	self.studentDetails = studentDetails;
	self.saveProfile = saveProfile;

	self.getAvatarImages = getAvatarImages;
	self.selectAvatar = selectAvatar;

	self.highlightPassword = highlightPassword;
	self.validateCurrentPassword = validateCurrentPassword;
	self.selectNewPassword = selectNewPassword;
	self.undoNewPassword = undoNewPassword;
	self.changePassword = changePassword;


	function setStudentProfileActive(active) {
	    self.errors = Constants.FALSE;
	    self.success = Constants.FALSE;
	    self.password_validated = Constants.FALSE;
	    self.password_selected = Constants.FALSE;
	    self.password_confirmed = Constants.FALSE;

	    self.active_index = Constants.FALSE;
	    self.active_email = Constants.FALSE;
	    self.active_confirm = Constants.FALSE;
	    self.active_edit = Constants.FALSE;
	    self.active_avatar = Constants.FALSE;
	    self.active_rewards = Constants.FALSE;
	    self.active_password = Constants.FALSE;

	    switch(active) {

	      case Constants.REWARDS  		:
	        self.active_rewards = Constants.TRUE;
	        break;

	      case Constants.AVATAR   		:
	        self.active_avatar = Constants.TRUE;
	        break;

	      case Constants.PASSWORD 		:
	        $scope.getLoginPassword();
	        self.active_password = Constants.TRUE;
	        break;

	      case Constants.EDIT    		:
	      	self.active_edit = Constants.TRUE;
	        break;

	      case Constants.EDIT_EMAIL 	:
	      	self.active_index = Constants.TRUE;
	      	self.active_edit_email = Constants.TRUE;
	      	break;

	      case Constants.CONFIRM_EMAIL  :
	      	self.active_index = Constants.TRUE;
	      	self.active_confirm_email = Constants.TRUE;
	      	break;

	      case Constants.INDEX    		:

	      default:
	      	self.studentDetails();
	      	self.active_index = Constants.TRUE;
	        break;
	    }

	    $('input, select').removeClass('required-field');
	    $("html, body").animate({ scrollTop: 0 }, "slow");
	  }

	  function studentDetails() {
	    apiService.studentDetails($scope.user.id).success(function(response) {
	      if(response.status == Constants.STATUS_OK) {
	        if(response.errors) {
	          self.errors = $scope.errorHandler(response.errors);
	        } else if(response.data) {
	          self.prof = response.data[0];
	          self.prof.birth = self.prof.birth_date;
	        } 
	      }
	    }).error(function(response) {
	      self.errors = $scope.internalError();
	    });
	  }

	  function saveProfile() {
	    self.errors = Constants.FALSE;

	    if($scope.e_error || $scope.u_error) {
	      $("html, body").animate({ scrollTop: 350 }, "slow");
	    } else {
	      self.prof.school_code = 1;
	      self.prof.birth_date = $("input[name='hidden_date']").val();

	      $scope.ui_block();
	      $('input select').removeClass('required-field');

	      apiService.saveProfile(self.prof).success(function(response) {
	        if(response.status == Constants.STATUS_OK) {
	          if(response.errors) {
	            self.errors = $scope.errorHandler(response.errors);

	            angular.forEach(response.errors, function(value, key) {
	              $("#profile_form input[name='" + value.field +"']").addClass("required-field");
	              $("#profile_form select[name='" + value.field +"']").addClass("required-field");
	            });
	          } else if(response.data){
	            $scope.user = response.data;
	            self.user = $scope.user;

	            apiService.updateUserSession(response.data).success(function(response) {
	              self.setStudentProfileActive(Constants.INDEX);
	              self.success = Constants.TRUE;
	            }).error(function() {
	              self.errors = $scope.internalError();
	            });
	            
	          }
	        } 

	        $scope.ui_unblock();
	      }).error(function(response) {
	        $scope.ui_unblock();
	        self.errors = $scope.internalError();
	      });
	    }

	    $("html, body").animate({ scrollTop: 0 }, "slow");
	  }

	  function getAvatarImages() {
	    apiService.getAvatarImages(self.user.gender).success(function(response) {
	        if(response.status == Constants.STATUS_OK) {
	          if(response.errors) {
	            self.errors = $scope.errorHandler(response.errors);
	          } else if(response.data){
	            self.avatars = response.data;
	          }
	        }
	    }).error(function(response) {
	        self.errors = $scope.internalError();
	    });
	  }

	function selectAvatar() {
	    apiService.selectAvatar(self.user.id, $scope.avatar_id).success(function(response) {
	      if(response.status == Constants.STATUS_OK) {
	        if(response.errors) {
	          self.errors = $scope.errorHandler(response.errors);
	        } else if(response.data){
	          $scope.user.avatar_id = response.data.id;
	          $scope.user.avatar = response.data.url;
	          self.success = Constants.TRUE;
	          apiService.updateUserSession($scope.user).success(function(response) {
	              $("ul.avatar_list li").removeClass('selected');
	          }).error(function() {
	            self.errors = $scope.internalError();
	          });
	        }
	      }
	    }).error(function(response) {
	      self.errors = $scope.internalError();
	    });
	}

	function highlightPassword(e) {
	    var target = getTarget(e);    

	    $("ul.form_password li").removeClass('selected');
	    $(target).addClass('selected');
	    self.image_id = $(target).find("#image_id").val();
	}

	function validateCurrentPassword() {
	    self.errors = Constants.FALSE;
	    self.image_id = self.image_id;

	    if(self.image_id) {
	      $scope.ui_block();
	      apiService.validateCurrentPassword(self.user.id, self.image_id).success(function(response) {
	        if(response.status == Constants.STATUS_OK) {
	          if(response.errors) {
	            self.errors = $scope.errorHandler(response.errors);
	          } else if(response.data){
	            self.image_id = Constants.FALSE;
	            self.password_validated = Constants.TRUE;
	            $scope.getImagePassword();
	          } 
	        }

	        $scope.ui_unblock();
	      }).error(function(response) {
	        $scope.ui_unblock();
	        self.errors = $scope.internalError();
	      });
	    } else {
	      self.errors = [Constants.MSG_PPW_INCORRECT];
	    }

	    $("html, body").animate({ scrollTop: 0 }, "slow");
	}

	function selectNewPassword() {
	    self.errors = Constants.FALSE;
	    self.password_selected = Constants.FALSE;
	    self.image_pass = $scope.$parent.image_pass;
	    
	    if(self.image_id) {
	      self.password_selected = Constants.TRUE;
	      self.new_password = self.image_id;

	      self.image_id = Constants.FALSE;
	      self.image_pass = shuffle(self.image_pass);
	      $("ul.form_password li").removeClass('selected');
	    } else {
	      self.errors = [Constants.MSG_PPW_SELECT_NEW];
	    }

	    $("html, body").animate({ scrollTop: 0 }, "slow");
	  }

	/**
	* Used by reset, set, and change password.
	*/
	function undoNewPassword() {
	    self.errors = Constants.FALSE;
	    self.image_pass = shuffle(self.image_pass);
	    self.password_selected = Constants.FALSE;
	    self.image_id = self.new_password;

	    $("ul.form_password li").removeClass("selected");
	    $("input[value='"+ self.new_password +"']").closest("li").addClass("selected");
	    $("html, body").animate({ scrollTop: 0 }, "slow");
	}

	function changePassword() {
	    self.errors = Constants.FALSE;

	    if(self.image_id == self.new_password) {
	        $scope.ui_block();
	        apiService.changePassword(self.user.id, self.new_password).success(function(response) {
	          if(response.status == Constants.STATUS_OK) {
	            if(response.errors) {
	              self.errors = $scope.errorHandler(response.errors);
	            } else if(response.data){
	              self.password_confirmed = Constants.TRUE;
	              $scope.$parent.image_pass = Constants.FALSE;
	            } 
	          }

	          $scope.ui_unblock();
	        }).error(function(response) {
	          $scope.ui_unblock();
	          self.errors = $scope.internalError();
	        });
	    } else {
	      self.errors = [Constants.MSG_PPW_NOT_MATCH];
	      $("html, body").animate({ scrollTop: 0 }, "slow");
	    }
	}
}