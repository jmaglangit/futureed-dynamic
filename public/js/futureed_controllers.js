angular.module('futureed.controllers', [])
  .controller('futureedController', FutureedController);

function FutureedController($scope, apiService) {
  $scope.display_date = new Date();
  
  /**
  * Common API calls
  */
  $scope.errorHandler = errorHandler;
  $scope.internalError = internalError;
  $scope.ui_block = ui_block;
  $scope.ui_unblock = ui_unblock;

  $scope.highlight = highlight;
  $scope.getCountries = getCountries;
  $scope.getGradeLevel = getGradeLevel;
  $scope.checkAvailability = checkAvailability;
  $scope.checkEmailAvailability = checkEmailAvailability;

  function errorHandler(errors) {
    $scope.errors = [];

    if(angular.isArray(errors)) {
      angular.forEach(errors, function(value, key) {
        $scope.errors[key] = value.message;
      });
    } else {
      $scope.errors[0] = errors.message;
    }

    $("html, body").animate({ scrollTop: 0 }, "slow");
    return $scope.errors;
  }

  function internalError() {
    $scope.errors = ["Internal Server Error."];
  }

  function ui_block() {
    $.blockUI({message : '<img src="/images/ajax-loader.gif" /> Please Wait...'});
  }

  function ui_unblock() {
    $.unblockUI();
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
          if(response.errors.error_code == 2001) {
            // In registration and Edit Profile
            $scope.u_success = Constants.TRUE;
          } else {
            $scope.u_error = response.errors[0].message;
          }
        } else if(response.data) {
          if($scope.user && (response.data.id == $scope.user.id)) {
            // In Edit Profile
            $scope.u_success = Constants.TRUE;
          } else {
            $scope.u_error = "Username already exist.";  
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

      if(response.status == 200) {
        if(response.errors) {
          if(response.errors.error_code == 2002) {
            $scope.e_success = Constants.TRUE;
          } else {
            $scope.e_error = response.errors[0].message;
          }
        } else if(response.data) {
          if($scope.user && (response.data.id == $scope.user.id)) {
            $scope.e_success = Constants.TRUE;
          } else {
            $scope.e_error = "Email already exist.";  
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

  // Registration
  $scope.showModal = showModal;
  $scope.validateRegistration = validateRegistration;
  $scope.studentConfirmRegistration = studentConfirmRegistration;
  $scope.studentResendConfirmation = studentResendConfirmation;
  $scope.saveNewPassword = saveNewPassword;

  // Profile
  $scope.setActive = setActive;

  $scope.editProfile = editProfile;
  $scope.saveProfile = saveProfile;
  $scope.validateCurrentPassword = validateCurrentPassword;
  $scope.getImagePassword = getImagePassword;
  $scope.selectNewPassword = selectNewPassword;
  $scope.undoNewPassword = undoNewPassword;
  $scope.changePassword = changePassword;
  $scope.studentDetails = studentDetails;

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
        } else if(response.data){
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
    var user = $('#userdata').val();

    if(angular.isString(user) && user.length > 0) {
      $scope.user = JSON.parse(user);
      $('#userdata').html('');
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

    $scope.ui_block();
    apiService.forgotPassword($scope.username, $scope.user_type).success(function(response) {
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
    $scope.resend = Constants.TRUE;
    $scope.username = (!isStringNullorEmpty($scope.username)) ? $scope.username : $("input[name='username']").val(); 
    $scope.studentForgotPassword();
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
    $scope.email = ($scope.email) ? $scope.email : $("input[name='username']").val();

    $scope.ui_block();
    apiService.validateCode($scope.code, $scope.email, $scope.user_type).success(function(response) {
      if(response.status == Constants.STATUS_OK) {
        if(response.errors) {
          $scope.errorHandler(response.errors);
        } else if(response.data){
          $("input[name='id']").val(response.data.id);
          $("#success_form").submit();
        } 
      }

      $scope.ui_unblock();
    }).error(function(response) {
      $scope.internalError();
      $scope.ui_unblock();
    });
  }

  function showModal(id) {
    $scope.show_terms = (id == 'terms_modal') ? true : false;
    $scope.show_policy = (id == 'policy_modal') ? true : false;
    $scope.show = true;


    $("#"+id).modal({
        backdrop: 'static',
        keyboard: false,
        show    : true
    });
  }

  function validateRegistration(reg, terms) {
    $scope.errors = Constants.FALSE;
    $scope.terms = angular.copy(terms);

    if($scope.e_error || $scope.u_error) {
      $("html, body").animate({ scrollTop: 320 }, "slow");
    } else {
      if(!terms) {
        $scope.errors = ["Please accept the terms and conditions."];
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return;
      }

      $scope.reg = reg;
      
      if($scope.reg) {
        $scope.reg.birth_date = $("input[name='birth_date']").val();
        $scope.reg.school_code = -1;
      }
      
      $scope.ui_block();
      apiService.validateRegistration($scope.reg).success(function(response) {
        if(response.status == Constants.STATUS_OK) {
          if(response.errors) {
            $scope.errorHandler(response.errors);

            angular.forEach(response.errors, function(value, key) {
              $("#" + value.field).addClass("required-field");
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
    $scope.email = (!isStringNullorEmpty($scope.email)) ? $scope.email : $("input[name='email']").val();
    $scope.confirmation_code = $("input[name='confirmation_code']").val();

    $scope.ui_block();
    apiService.confirmCode($scope.email, $scope.confirmation_code, $scope.user_type).success(function(response) {
      if(response.status == Constants.STATUS_OK) {
        if(response.errors) {
          $scope.errorHandler(response.errors);
        } else if(response.data){
          $("input[name='id']").val(response.data.id);
          $("#success_form").submit();
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
    $scope.email = (!isStringNullorEmpty($scope.email)) ? $scope.email : $("input[name='email']").val();

    $scope.ui_block();
    apiService.resendConfirmation($scope.email, $scope.user_type).success(function(response) {
      if(response.status == Constants.STATUS_OK) {
        if(response.errors) {
          $scope.errorHandler(response.errors);
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
      var code = $("input[name='code']").val();
      var id = $("input[name='id']").val();

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
      $scope.errors = ["Password does not match."];
      $("html, body").animate({ scrollTop: 0 }, "slow");
    }
  }

  function setActive(active) {
    $scope.errors = Constants.FALSE;
    $scope.success_msg = Constants.FALSE;
    $scope.e_error = Constants.FALSE;
    $scope.u_error = Constants.FALSE;
    $scope.e_success = Constants.FALSE;
    $scope.u_success = Constants.FALSE;

    switch(active) {
      case "rewards"  :
        $scope.active_rewards = 1;
        break;
      case "avatar"   :
        $scope.active_avatar = 1;
        break;
      case "password" :
        $scope.getLoginPassword();
        $scope.active_password = 1;
        break;
      case "index"    :
      default:
        $scope.studentDetails();
        $scope.active_index = 1;
        $scope.edit = Constants.FALSE;

        $("html, body").animate({ scrollTop: 0 }, "slow");
        break;
    }
  }

  function editProfile() {
    $scope.studentDetails();
    $scope.edit = Constants.TRUE;

    $("html, body").animate({ scrollTop: 0 }, "slow");
  }

  function saveProfile(prof) {
    $scope.errors = Constants.FALSE;

    if($scope.e_error || $scope.u_error) {
      $("html, body").animate({ scrollTop: 350 }, "slow");
    } else {
      $scope.prof.school_code = 1;
      $scope.prof.birth_date = $("input[name='birth_date']").val();

      $scope.ui_block();
      apiService.saveProfile($scope.prof).success(function(response) {
        if(response.status == Constants.STATUS_OK) {
          if(response.errors) {
            $scope.errorHandler(response.errors);

            angular.forEach(response.errors, function(value, key) {
              $("#" + value.field).addClass("required-field");
            });
          } else if(response.data){
            $scope.setActive('index');
            $scope.success = Constants.TRUE;
          }
        } 

        $scope.ui_unblock();
      }).error(function(response) {
        $scope.ui_unblock();
        $scope.internalError();
      });
    }

    $("html, body").animate({ scrollTop: 0 }, "slow");
  }

  /**
  * On change password, validates the selected current password.
  */
  function validateCurrentPassword() {
    $scope.errors = Constants.FALSE;

    if($scope.image_id) {
      $scope.ui_block();
      apiService.validateCurrentPassword($scope.user.id, $scope.image_id).success(function(response) {
        if(response.status == Constants.STATUS_OK) {
          if(response.errors) {
            $scope.errorHandler(response.errors);
          } else if(response.data){
            $scope.image_id = Constants.FALSE;
            $scope.password_validated = Constants.TRUE;
            
            $scope.getImagePassword();
          } 
        }

        $scope.ui_unblock();
      }).error(function(response) {
        $scope.ui_unblock();
        $scope.internalError();
      });
    } else {
      $scope.errors = ["Picture password is incorrect"];
    }

    $("html, body").animate({ scrollTop: 0 }, "slow");
  }

  /**
  * Used by reset, set, and change password.
  */
  function selectNewPassword() {
    $scope.password_selected = Constants.FALSE;
    $scope.errors = Constants.FALSE;

    if($scope.image_id) {
      $scope.password_selected = true;
      $scope.new_password = $scope.image_id;
      $scope.image_id = "";
      $scope.image_pass = shuffle($scope.image_pass);
      $("ul.form_password li").removeClass('selected');
    } else {
      $scope.errors = ["Please select a new picture password"];
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

  /**
  * Used to change password
  */
  function changePassword() {
    $scope.errors = Constants.FALSE;

    if($scope.image_id == $scope.new_password) {
        $scope.ui_block();
        apiService.changePassword($scope.user.id, $scope.image_id, $scope.user.access_token).success(function(response) {
          if(response.status == Constants.STATUS_OK) {
            if(response.errors) {
              $scope.errorHandler(response.errors);
            } else if(response.data){
              $scope.password_confirmed = Constants.TRUE;
            } 
          }

          $scope.ui_unblock();
        }).error(function(response) {
          $scope.ui_unblock();
          $scope.internalError();
        });
    } else {
      $scope.errors = ["Password does not match"];
      $("html, body").animate({ scrollTop: 0 }, "slow");
    }
  }

  function studentDetails() {
    apiService.studentDetails($scope.user.id, $scope.user.access_token).success(function(response) {
      if(response.status == 200) {
        if(response.errors) {
          $scope.errorHandler(response.errors);
        } else if(response.data) {
          $scope.prof = response.data[0];
          $scope.prof.access_token = $scope.user.access_token;
          $scope.user = $scope.prof;

          $scope.prof.birth = $scope.prof.birth_date;
        } 
      }
    }).error(function(response) {
      $scope.internalError();
    });
  }

  function getAvatarImages(change) {
    if(change || $scope.user.avatar_id == null || $scope.user.avatar_id == "") {
      apiService.getAvatarImages($scope.user.gender).success(function(response) {
        if(response.status == 200) {
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
      $scope.has_avatar = true;
    }
  }

  function highlightAvatar(e) {
    var target = getTarget(e);

    $("ul.avatar_list li").removeClass('selected');
    $(target).addClass('selected');
    $scope.avatar_id = $(target).find("#avatar_id").val(); 
  }

  function selectAvatar() {
    apiService.selectAvatar($scope.user.id, $scope.avatar_id).success(function(response) {
      if(response.status == 200) {
        if(response.errors) {
          $scope.errorHandler(response.errors);
        } else if(response.data){
          $scope.user.avatar_id = response.data.id;
          $scope.user.avatar = response.data.url;
        
          $scope.session_user = $scope.user;
          $scope.has_avatar = true;
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
  $scope.clientLogin = clientLogin;

  $scope.clientForgotPassword = clientForgotPassword;
  $scope.clientResendCode = clientResendCode;
  $scope.clientValidateCode = clientValidateCode;
  $scope.resetClientPassword = resetClientPassword;

  $scope.selectRole = selectRole;
  $scope.registerClient = registerClient;
  $scope.resendClientConfirmation = resendClientConfirmation;
  $scope.confirmClientRegistration = confirmClientRegistration;

  function clientLogin() {
    $scope.errors = Constants.FALSE;

    $scope.ui_block()
    apiService.clientLogin($scope.username, $scope.password, $scope.role).success(function(response) {
      if(response.status == Constants.STATUS_OK) {
        if(response.errors) {
          $scope.errorHandler(response.errors);
        } else if(response.data) {
          $("input[name='user_data']").val(JSON.stringify(response.data));
          $("#login_form").submit();  
        }
      }

      $scope.ui_unblock();
    }).error(function(response) {
      $scope.ui_unblock();
      $scope.internalError();
    });
  }

  function clientForgotPassword() {
    $scope.errors = Constants.FALSE;
    $scope.user_type = Constants.CLIENT;

    $scope.ui_block();
    apiService.forgotPassword($scope.username, $scope.user_type).success(function(response) {
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

  function clientResendCode() {
    $scope.resend = Constants.TRUE;
    $scope.username = (!isStringNullorEmpty($scope.username)) ? $scope.username : $("input[name='username']").val(); 
    $scope.clientForgotPassword();
  }

  function clientValidateCode(code) {
    $scope.errors = Constants.FALSE;
    $scope.code = code;
    $scope.user_type = Constants.CLIENT;
    $scope.email = (!isStringNullorEmpty($scope.email)) ? $scope.email : $("input[name='username']").val();

    $scope.ui_block();
    apiService.validateCode($scope.code, $scope.email, $scope.user_type).success(function(response) {
      if(response.status == 200) {
        if(response.errors) {
          $scope.errorHandler(response.errors);
        } else if(response.data){
          $("input[name='id']").val(response.data.id);
          $("#success_form").submit();
        } 
      }

      $scope.ui_unblock();
    }).error(function(response) {
      $scope.internalError();
      $scope.ui_unblock();
    });
  }

  function resetClientPassword() {
    $scope.errors = Constants.FALSE;

    if($scope.new_password == $scope.confirm_password) {
      var reset_code = $("input[name='reset_code']").val();
      var id = $("input[name='id']").val();

      $scope.ui_block();
      apiService.resetClientPassword(id, reset_code, $scope.new_password).success(function(response) {
        if(response.status == Constants.STATUS_OK) {
          if(response.errors) {
            $scope.errorHandler(response.errors);
          } else if(response.data) {
            $scope.success = Constants.TRUE;
          }
        }

        $scope.ui_unblock();
      }).error(function(response) {
        $scope.internalError();
        $scope.ui_unblock();
      });
    } else {
      $scope.errors = ["Password does not match"];
      $("html, body").animate({ scrollTop: 0 }, "slow");
    }
  }

  function selectRole(role) {
    $scope.principal = Constants.FALSE;
    $scope.teacher = Constants.FALSE;
    $scope.parent = Constants.FALSE;

    $scope.reg = ($scope.reg) ? $scope.reg: {} ;

    switch(role) {
      case "user_principal"  :
        $scope.principal = Constants.TRUE;
        $scope.reg.client_role = "Principal";
        break;
      case "user_teacher"   :
        $scope.teacher = Constants.TRUE;
        $scope.reg.client_role = "Teacher";
        break;
      case "user_parent" :
        $scope.parent = Constants.TRUE;
        $scope.reg.client_role = "Parent";
        break;
      default:
        break;
    }
  }

  function registerClient(reg, term) {
    $scope.errors = false;
    $scope.reg = reg;

    if($scope.e_error || $scope.u_error) {
      $("html, body").animate({ scrollTop: 320 }, "slow");
    } else if(!term) {
      $scope.errors = ["Please accept the terms and conditions."];
      $("html, body").animate({ scrollTop: 0 }, "slow");
    } else if($scope.reg && ($scope.reg.password != $scope.reg.confirm_password)) {
      $scope.errors = ["Password does not match."];
      $("html, body").animate({ scrollTop: 0 }, "slow");
    } else {
      $scope.ui_block();
      apiService.registerClient(reg).success(function(response) {
        if(response.status == Constants.STATUS_OK) {
          if(response.errors) {
            $scope.errorHandler(response.errors);

            angular.forEach(response.errors, function(value, key) {
              $("#" + value.field).addClass("required-field");
            });
          } else if(response.data) {
            $scope.registered = Constants.TRUE; 
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

  function resendClientConfirmation() {
    $scope.errors = Constants.FALSE;
    $scope.user_type = Constants.CLIENT;
    $scope.email = (!isStringNullorEmpty($scope.email)) ? $scope.email : $("input[name='email']").val();

    $scope.ui_block();
    apiService.resendConfirmation($scope.email, $scope.user_type).success(function(response) {
      if(response.status == Constants.STATUS_OK) {
        if(response.errors) {
          $scope.errorHandler(response.errors);
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

  function confirmClientRegistration() {
    $scope.errors = FALSE;
    $scope.user_type = Constants.CLIENT;
    $scope.confirmation_code = $("input[name='confirmation_code']").val();

    $scope.ui_block();
    apiService.confirmCode($scope.email, $scope.confirmation_code, $scope.user_type).success(function(response) {
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
  }

  /**
  * End of Client Page Functions
  */
};