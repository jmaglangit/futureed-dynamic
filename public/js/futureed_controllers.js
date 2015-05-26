angular.module('futureed.controllers', ['datatables','ngResource'])
  .controller('futureedController', FutureedController)
  .directive('templateDirective', TemplateDirective);

function TemplateDirective() {
  return {
    templateUrl : function(scope, element, attrs) {
      return element.templateUrl;
    }
  }
}

function FutureedController($scope, apiService) {
  $scope.display_date = new Date();
  
  /**
  * Common API calls
  */
  $scope.errorHandler = errorHandler;
  $scope.internalError = internalError;
  $scope.ui_block = ui_block;
  $scope.ui_unblock = ui_unblock;

  $scope.goHome = goHome;
  $scope.highlight = highlight;
  $scope.getCountries = getCountries;
  $scope.getGradeLevel = getGradeLevel;
  $scope.checkAvailability = checkAvailability;
  $scope.checkEmailAvailability = checkEmailAvailability;
  $scope.getAnnouncement = getAnnouncement;

  $scope.beforeDateRender = beforeDateRender;

  function beforeDateRender($dates){
    maxDate = new Date().setHours(0,0,0,0); // Set minimum date to whatever you want here

    for(d in $dates){        
        if($dates[d].utcDateValue > maxDate){
            $dates[d].selectable = false;
        }
    }
  }

  function errorHandler(errors) {
    $scope.errors = [];

    if(angular.isArray(errors)) {
      angular.forEach(errors, function(value, key) {

        if(value.error_code == 2102) {
          $scope.user = null;

          apiService.updateUserSession($scope.user).success(function(response) {
            window.location.href = "/student/login";
          }).error(function() {
            $scope.internalError();
          });
        }

        $scope.errors[key] = value.message;
      });
    } else {
      $scope.errors[0] = errors.message;
    }

    $("html, body").animate({ scrollTop: 0 }, "slow");
    return $scope.errors;
  }

  function internalError() {
    $scope.errors = [Constants.MSG_INTERNAL_ERROR];
    $("html, body").animate({ scrollTop: 0 }, "slow");

    return $scope.errors;
  }

  function ui_block() {
    $.blockUI({message : '<img src="/images/ajax-loader.gif" /> Please Wait...'});
  }

  function ui_unblock() {
    $.unblockUI();
  }

  function goHome() {
    
  }

  function highlight(e) {
    var target = getTarget(e);    

    $("ul.form_password li").removeClass('selected');
    $(target).addClass('selected');
    $scope.image_id = $(target).find("#image_id").val();
  }

  /**
  * Retrieves a list of countries
  */
  function getCountries() {
    $scope.countries = Constants.FALSE;

    apiService.getCountries().success(function(response) {
      if(response.status == Constants.STATUS_OK) {
        if(response.errors) {
          $scope.errorHandler(response.errors);
        } else if(response.data) {
          $scope.countries = response.data;
        }
      }
    }).error(function(response) {
      $scope.internalError();
    });
  }

  function getGradeLevel() {
    $scope.grades = Constants.FALSE;

    apiService.getGradeLevel().success(function(response) {
      if(response.status == Constants.STATUS_OK) {
        if(response.errors) {
          $scope.errorHandler(response.errors);
        } else if(response.data) {
          $scope.grades = response.data;
        }
      }
    }).error(function(response) {
      $scope.internalError();
    });
  }

  function checkAvailability(username, user_type) {
    $scope.u_loading = Constants.TRUE;
    $scope.u_success = Constants.FALSE;
    $scope.u_error = Constants.FALSE;

    apiService.validateUsername(username, user_type).success(function(response) {
      $scope.u_loading = Constants.FALSE;

      if(response.status == Constants.STATUS_OK) {
        if(response.errors) {
          if(response.errors[0].error_code == 2001) {
            // In registration and Edit Profile
            $scope.u_success = "Username is available." ;
          } else {
            $scope.u_error = response.errors[0].message;
          }
        } else if(response.data) {
          if($scope.user && (response.data.id == $scope.user.id)) {
            // In Edit Profile
            $scope.u_success = "Username is available." ;
          } else {
            $scope.u_error = "Username already exists.";  
          }
        }
      }
    }).error(function(response) {
      $scope.u_loading = Constants.FALSE;
      $scope.internalError();
    });
  }

  function checkEmailAvailability(email, user_type) {
    $scope.e_loading = Constants.TRUE;
    $scope.e_success = Constants.FALSE;
    $scope.e_error = Constants.FALSE;

    apiService.validateEmail(email, user_type).success(function(response) {
      $scope.e_loading = Constants.FALSE;

      if(response.status == Constants.STATUS_OK) {
        if(response.errors) {
          if(response.errors[0].error_code == 2002) {
            $scope.e_success = Constants.TRUE;
          } else {
            $scope.e_error = response.errors[0].message;
          }
        } else if(response.data) {
          if($scope.user && (response.data.id == $scope.user.id)) {
            $scope.e_success = Constants.TRUE;
          } else {
            $scope.e_error = "Email Address already exists.";  
          }
        }
      }
    }).error(function(response) {
      $scope.e_loading = Constants.FALSE;
      $scope.internalError();
    });
  }  
  /**
  * End of Common Functions / API calls
  */

  /**
  * Student Page with API calls
  */
  // Login 
  $scope.validateUser = validateUser;
  $scope.validatePassword = validatePassword;
  $scope.getLoginPassword = getLoginPassword;
  $scope.selectPassword = selectPassword;
  $scope.cancelLogin = cancelLogin;
  $scope.getUserDetails = getUserDetails;

  //Forgot Password
  $scope.studentForgotPassword = studentForgotPassword;
  $scope.studentResendCode = studentResendCode;
  $scope.studentValidateCode = studentValidateCode;
  $scope.studentResetPassword = studentResetPassword;

  // Registration
  $scope.showModal = showModal;
  $scope.validateRegistration = validateRegistration;
  $scope.studentConfirmRegistration = studentConfirmRegistration;
  $scope.studentResendConfirmation = studentResendConfirmation;
  $scope.saveNewPassword = saveNewPassword;

  // Profile
  $scope.updateAge = updateAge;
  $scope.getImagePassword = getImagePassword;
  $scope.selectNewPassword = selectNewPassword;
  $scope.undoNewPassword = undoNewPassword;

  $scope.getAvatarImages = getAvatarImages;
  $scope.highlightAvatar = highlightAvatar;
  $scope.selectAvatar = selectAvatar;

  /**
  * Validate Student Email Address / Username
  * 
  * @Params 
  *   username - the username
  */
  function validateUser() {
    $scope.errors = Constants.FALSE;

    $scope.ui_block();
    apiService.validateUser($scope.username).success(function(response) {
      if(response.status == Constants.STATUS_OK) {
        if(response.errors) {
          $scope.errorHandler(response.errors);
        } else if(response.data){
          $scope.id = response.data.id;
          $scope.getLoginPassword();
          $scope.enter_pass = Constants.TRUE;
        } 
      }

      $scope.ui_unblock();
    }).error(function(response) {
      $scope.ui_unblock();
      $scope.internalError();
    });
  }

  function getLoginPassword() {
    $scope.id = ($scope.id) ? $scope.id : $scope.user.id;

    apiService.getLoginPassword($scope.id).success(function (response) {
      if(response.status == Constants.STATUS_OK) {
        if(response.errors) {
          $scope.errorHandler(response.errors);
        } else if(response.data) {
          $scope.image_pass = response.data
        }
      }
    }).error(function(response) {
      $scope.internalError();
    });
  }

  /**
  * Validate Selected Image Password
  * 
  * @Params 
  *   id        - the student id
  *   image_id  - selected image password
  */
  function validatePassword() {
    $scope.errors = Constants.FALSE;

    $scope.ui_block();
    apiService.validatePassword($scope.id, $scope.image_id).success(function(response) {
      if(response.status == Constants.STATUS_OK) {
        if(response.errors) {
          $scope.errorHandler(response.errors);
          $scope.image_pass = shuffle($scope.image_pass);
        } else if(response.data){
          $scope.user = JSON.stringify(response.data);
          $("input[name='user_data']").val(JSON.stringify(response.data));
          $("#password_form").submit();
        } 
      }

      $scope.ui_unblock();
    }).error(function(response) {
      $scope.ui_unblock();
      $scope.internalError();
    });
  } 

  /**
  * Highlight the selected image password; Validate.
  *
  */
  function selectPassword(e) {
      $scope.highlight(e);
      $scope.validatePassword();
  }

  /**
  * Cancel selection of Image Password. 
  */
  function cancelLogin() {
    $scope.errors = Constants.FALSE;
    $scope.enter_pass = Constants.FALSE;
    $scope.id = "";
    $scope.username = "";
  }

  function getUserDetails() {
    var user = $("input[name='userdata']").val();

    if(angular.isString(user) && user.length > 0) {
      $scope.user = JSON.parse(user);
      if($scope.user.new_email != null){
        $scope.confirm_email = Constants.TRUE;
      }

      $("input[name='userdata']").val('');
    }
  }

  /**
  * Sends a reset code to the valid email
  *
  * @Params
  *   username    - the username
  *   user_type   - Student
  */
  function studentForgotPassword() {
    $scope.errors = Constants.FALSE;
    $scope.user_type = Constants.STUDENT;
    $scope.base_url = $("#base_url_form input[name='base_url']").val();
    $scope.forgot_password_url = $scope.base_url + Constants.URL_FORGOT_PASSWORD(angular.lowercase($scope.user_type));

    $scope.ui_block();
    apiService.forgotPassword($scope.username, $scope.user_type, $scope.forgot_password_url).success(function(response) {
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

  /**
  * Creates a new reset code then sends the code to the valid email
  * 
  * Params: username - the specified username, or the email from link
  */
   function studentResendCode() {
    $scope.errors = Constants.FALSE;
    $scope.user_type = Constants.STUDENT;
    $scope.email = (!isStringNullorEmpty($scope.email)) ? $scope.email : $("#redirect_form input[name='email']").val(); 
    $scope.base_url = $("#base_url_form input[name='base_url']").val();
    $scope.resend_code_url = $scope.base_url + Constants.URL_FORGOT_PASSWORD(angular.lowercase($scope.user_type));

    $scope.ui_block();
    apiService.resendResetCode($scope.email, $scope.user_type, $scope.resend_code_url).success(function(response) {
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

  /**
  * Validate the reset code
  *
  * @Params
  *   code      - the reset code
  *   email     - the email address; from scope or from link
  *   user_type - Student 
  */
  function studentValidateCode(code) {
    $scope.errors = Constants.FALSE;
    $scope.user_type = Constants.STUDENT;
    $scope.code = code;
    $scope.email = ($scope.email) ? $scope.email : $("#redirect_form input[name='email']").val();

    $scope.ui_block();
    apiService.validateCode($scope.code, $scope.email, $scope.user_type).success(function(response) {
      if(response.status == Constants.STATUS_OK) {
        if(response.errors) {
          $scope.errorHandler(response.errors);
        } else if(response.data){
          $("#redirect_form input[name='id']").val(response.data.id);
          $("#redirect_form input[name='reset_code']").val($scope.code);
          $("#redirect_form").submit();
        } 
      }

      $scope.ui_unblock();
    }).error(function(response) {
      $scope.internalError();
      $scope.ui_unblock();
    });
  }

  function studentResetPassword() {
    $scope.errors = Constants.FALSE;

    if($scope.new_password == $scope.image_id) {
      var id = $("input[name='id']").val();
      var code = $("input[name='code']").val();

      $scope.ui_block();
      apiService.resetPassword(id, code, $scope.new_password).success(function(response) {
        if(response.status == Constants.STATUS_OK) {
          if(response.errors) {
            $scope.errorHandler(response.errors);
          } else if(response.data){
            $scope.success = Constants.TRUE;
          } 
        }

        $scope.ui_unblock();
      }).error(function(response) {
        $scope.internalError();
        $scope.ui_unblock();
      });
    } else {
      $scope.errors = [Constants.MSG_PPW_NOT_MATCH];
      $("html, body").animate({ scrollTop: 0 }, "slow");
    }
  }

  function showModal(id) {
    $scope.show_terms = (id == 'terms_modal') ? Constants.TRUE : Constants.FALSE;
    $scope.show_policy = (id == 'policy_modal') ? Constants.TRUE : Constants.FALSE;
    $scope.show = Constants.TRUE;


    $("#"+id).modal({
        backdrop: 'static',
        keyboard: Constants.FALSE,
        show    : Constants.TRUE
    });
  }

  function validateRegistration(reg, terms) {
    $scope.errors = Constants.FALSE;
    $scope.terms = terms;

    if($scope.e_error || $scope.u_error) {
      $("html, body").animate({ scrollTop: 320 }, "slow");
    } else {
      if(!terms) {
        $scope.errors = ["Please accept the terms and conditions."];
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return;
      }

      $scope.reg = (reg) ? reg : {};
      $scope.base_url = $("#base_url_form input[name='base_url']").val();
      $scope.reg.callback_uri = $scope.base_url + Constants.URL_REGISTRATION(angular.lowercase(Constants.STUDENT));


      if($scope.reg) {
        $scope.reg.birth_date = $("#registration_form input[name='hidden_date']").val();
        $scope.reg.school_code = -1;
      }
      
      $scope.ui_block();
      $('#registration_form input').removeClass('required-field');
      $('#registration_form select').removeClass('required-field');

      apiService.validateRegistration($scope.reg).success(function(response) {
        if(response.status == Constants.STATUS_OK) {
          if(response.errors) {
            $scope.errorHandler(response.errors);

            angular.forEach(response.errors, function(value, key) {
              $("#registration_form input[name='" + value.field +"']").addClass("required-field");
              $("#registration_form select[name='" + value.field +"']").addClass("required-field");
            });
          } else if(response.data){
            $scope.success = Constants.TRUE;
            $scope.email = $scope.reg.email;
          }
        }

        $scope.ui_unblock();
      }).error(function(response) {
        $scope.internalError();
        $scope.ui_unblock();
      });
    }
  }

  function studentConfirmRegistration() {
    $scope.errors = Constants.FALSE;
    $scope.user_type = Constants.STUDENT;
    $scope.email = (!isStringNullorEmpty($scope.email)) ? $scope.email : $("#redirect_form input[name='email']").val();
    $scope.confirmation_code = $("#registration_success_form input[name='confirmation_code']").val();

    $scope.ui_block();
    apiService.confirmCode($scope.email, $scope.confirmation_code, $scope.user_type).success(function(response) {
      if(response.status == Constants.STATUS_OK) {
        if(response.errors) {
          $scope.errorHandler(response.errors);
        } else if(response.data){
          $("#redirect_form input[name='id']").val(response.data.id);
          $("#redirect_form input[name='confirmation_code']").val($scope.confirmation_code);
          $("#redirect_form").submit();
        } 
      }

      $scope.ui_unblock();
    }).error(function(response) {
      $scope.internalError();
      $scope.ui_unblock();
    });
  }

  /**
  * 
  * 
  * @Params
  *   email     - the email; from scope or from link
  *   user_type - Student
  */
  function studentResendConfirmation() {
    $scope.errors = Constants.FALSE;
    $scope.user_type = Constants.STUDENT;
    $scope.email = (!isStringNullorEmpty($scope.email)) ? $scope.email : $("#redirect_form input[name='email']").val();
    $scope.base_url = $("#base_url_form input[name='base_url']").val();
    $scope.resend_confirmation_url = $scope.base_url + Constants.URL_REGISTRATION(angular.lowercase($scope.user_type));

    $scope.ui_block();
    apiService.resendConfirmation($scope.email, $scope.user_type, $scope.resend_confirmation_url).success(function(response) {
      if(response.status == Constants.STATUS_OK) {
        if(response.errors) {
          $scope.errorHandler(response.errors);

          angular.forEach($scope.errors, function(value, key) {
            if(angular.equals(value, Constants.MSG_ACC_CONFIRMED)) {
              $scope.account_confirmed = Constants.TRUE;
            }
          });
        } else if(response.data) {
          $scope.resent = Constants.TRUE;
        }
      }
      $scope.ui_unblock();
    }).error(function(response) {
      $scope.internalError();
      $scope.ui_unblock();
    });
  }

  /**
  * [Registration] Save new password after email confirmation.
  */
  function saveNewPassword() {
    $scope.errors = Constants.FALSE;

    if($scope.new_password == $scope.image_id) {
      var id = $("input[name='id']").val();

      $scope.ui_block();
      apiService.setPassword(id, $scope.new_password).success(function(response) {
        if(response.status == Constants.STATUS_OK) {
          if(response.errors) {
            $scope.errorHandler(response.errors);
          } else if(response.data){
            $scope.success = Constants.TRUE;
          } 
        }

        $scope.ui_unblock();
      }).error(function(response) {
        $scope.internalError();
        $scope.ui_unblock();
      });
    } else {
      $scope.errors = [Constants.MSG_PPW_NOT_MATCH];
      $("html, body").animate({ scrollTop: 0 }, "slow");
    }
  }

  function updateAge() {
    
  }

  /**
  * Used by reset, set, and change password.
  */
  function selectNewPassword() {
    $scope.password_selected = Constants.FALSE;
    $scope.errors = Constants.FALSE;

    if($scope.image_id) {
      $scope.password_selected = Constants.TRUE;
      $scope.new_password = $scope.image_id;
      $scope.image_id = Constants.FALSE;
      $scope.image_pass = shuffle($scope.image_pass);
      $("ul.form_password li").removeClass('selected');
    } else {
      $scope.errors = [Constants.MSG_PPW_SELECT_NEW];
    }

    $("html, body").animate({ scrollTop: 0 }, "slow");
  }

  /**
  * Used by reset, set, and change password.
  */
  function undoNewPassword() {
    $scope.errors = Constants.FALSE;
    $scope.image_pass = shuffle($scope.image_pass);
    $scope.password_selected = Constants.FALSE;
    $scope.image_id = $scope.new_password;

    $("ul.form_password li").removeClass("selected");
    $("input[value='"+$scope.new_password+"']").closest("li").addClass("selected");

    $("html, body").animate({ scrollTop: 0 }, "slow");
  }

  function getAvatarImages(change) {
    if(change || $scope.user.avatar_id == null || $scope.user.avatar_id == "") {
      apiService.getAvatarImages($scope.user.gender).success(function(response) {
        if(response.status == Constants.STATUS_OK) {
          if(response.errors) {
            $scope.errorHandler(response.errors);
          } else if(response.data){
            $scope.avatars = response.data;
          }
        }
      }).error(function(response) {
        $scope.internalError();
      });
    } else {
      $scope.has_avatar = Constants.TRUE;
    }
  }

  function highlightAvatar(e) {
    var target = getTarget(e);

    $("ul.avatar_list li").removeClass('selected');
    $(target).addClass('selected');
    $scope.avatar_id = $(target).find("#avatar_id").val(); 
    $scope.enable = Constants.TRUE;
  }

  function selectAvatar() {
    apiService.selectAvatar($scope.user.id, $scope.avatar_id).success(function(response) {
      if(response.status == Constants.STATUS_OK) {
        if(response.errors) {
          $scope.errorHandler(response.errors);
        } else if(response.data){
          $scope.user.avatar_id = response.data.id;
          $scope.user.avatar = response.data.url;
        
          $scope.session_user = $scope.user;
          $scope.has_avatar = Constants.TRUE;
          apiService.updateUserSession($scope.user).success(function(response) {
              $("ul.avatar_list li").removeClass('selected');
          }).error(function() {
            $scope.internalError();
          });
        }
      }
    }).error(function(response) {
      $scope.internalError();
    });
  }

  function getImagePassword() {
    apiService.getImagePassword().success(function(response) {
      if(response.status == Constants.STATUS_OK) {
        if(response.errors) {
          $scope.errorHandler(response.errors);
        } else if(response.data) {
          $scope.image_pass = response.data;
        }
      }
    }).error(function(response) {
      $scope.internalError();
    });
  }
  /**
  * End of Student Page Functions
  */

  /**
  * Client Page With API calls
  */
  $scope.saveEmail = saveEmail;

  function saveEmail() {

    $scope.error = "";
    $scope.success_msg = "";

    if($scope.c_error != false || $scope.n_error != false || $scope.cf_error != false){
      $scope.error = "Please fill up required fields";
    }else{
      $scope.getLoginPassword();
      $scope.email_pass = Constants.TRUE;

    }
    $("html, body").animate({ scrollTop: 0 }, "slow");
  }

  /**
  * Get announcement
  */
  function getAnnouncement(){
    apiService.getAnnouncement().success(function(response){
        if(angular.equals(response.status, Constants.STATUS_OK)){
          if(!isDataEmpty(response.data)){
            $scope.announce = response.data;
          }
        }
    }).error(function(response){
        $scope.internalError();
    });
  }
};