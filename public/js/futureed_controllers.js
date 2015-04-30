angular.module('futureed.controllers', [])
  .controller('futureedController', FutureedController);

function FutureedController($scope, $location, apiService) {
  $scope.error = "";
  $scope.display_date = new Date();
  
  /**
  * Common API calls
  */
  $scope.errorHandler = errorHandler;
  $scope.internalError = internalError;
  $scope.ui_block = ui_block;
  $scope.ui_unblock = ui_unblock;

  $scope.checkAvailability = checkAvailability;
  $scope.checkEmailAvailability = checkEmailAvailability;
  $scope.getCountries = getCountries;
  $scope.highlight = highlight;


  function errorHandler(errors) {
    $scope.error_object = (typeof errors[0] != "undefined") ? errors[0] : errors;
    $scope.error = $scope.error_object.message;

    $("html, body").animate({ scrollTop: 0 }, "slow");
    return $scope.error_object.error_code;
  }

  function internalError() {
    $scope.error = "Internal Server Error";
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
    $scope.countries = {};

    apiService.getCountries().success(function(response) {
      if(response.status == 200) {
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

  function checkAvailability(username, user_type) {
    $scope.error = "";
    $scope.u_loading = true;
    $scope.u_success = false;
    $scope.u_error = false;

    apiService.validateUsername(username, user_type).success(function(response) {
      $scope.u_loading = false;

      if(response.status == 200) {
        if(response.errors) {
          var error_code = $scope.errorHandler(response.errors);
          if(error_code == 2001) {
            // In registration and Edit Profile
            $scope.u_success = true;
          } else {
            $scope.u_error = $scope.error;
          }

          $scope.error = "";
        } else if(response.data) {
          if($scope.user && (response.data.id == $scope.user.id)) {
            // In Edit Profile
            $scope.u_success = true;
          } else {
            $scope.u_error = "Username already exist.";  
          }
        }
      }
    }).error(function(response) {
      $scope.u_loading = false;
      $scope.internalError();
    });
  }

  function checkEmailAvailability(email, user_type) {
    $scope.error = "";
    $scope.e_loading = true;
    $scope.e_success = false;
    $scope.e_error = false;

    apiService.validateEmail(email, user_type).success(function(response) {
      $scope.e_loading = false;

      if(response.status == 200) {
        if(response.errors) {
          var error_code = $scope.errorHandler(response.errors);
          if(error_code == 2002) {
            $scope.e_success = true;
          } else {
            $scope.e_error = $scope.error;
          }

          $scope.error = "";
        } else if(response.data) {
          if($scope.user && (response.data.id == $scope.user.id)) {
            $scope.e_success = true;
          } else {
            $scope.e_error = "Email already exist.";  
          }
        }
      }
    }).error(function(response) {
      $scope.ui_unblock;
      $scope.e_loading = false;
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
  $scope.selectPassword = selectPassword;
  $scope.cancelLogin = cancelLogin;

  //Forgot Password
  $scope.studentForgotPassword = studentForgotPassword;
  $scope.studentResendCode = studentResendCode;
  $scope.studentValidateCode = studentValidateCode;

  // Registration
  $scope.validateRegistration = validateRegistration;
  $scope.confirmStudentRegistration = confirmStudentRegistration;
  $scope.resendStudentConfirmation = resendStudentConfirmation;

  // Profile
  $scope.saveProfile = saveProfile;

  function validateUser() {
    $scope.error = "";

    apiService.validateUser($scope.username).success(function (response) {
        if(response.status == 200) {
          if(response.errors) {
            $scope.errorHandler(response.errors);
          } else if(response.data){
            $scope.id = response.data.id;
            $scope.getLoginPassword();
            $scope.enter_pass = true;
          } 
        } else if(response.status == 202) {
          $scope.error = response.data.message;
        }
    }).error(function(response) {
        $scope.internalError();
    });
  }

  function validatePassword() {
    $scope.error = "";

    apiService.validatePassword($scope.id, $scope.image_id).success(function(response) {
      if(response.status == 200) {
        if(response.errors) {
          $scope.errorHandler(response.errors);
        } else if(response.data){
          $("input[name='user_data']").val(JSON.stringify(response.data));
          $("#password_form").submit();
        } 
      } else if(response.status == 202) {
        $scope.error = response.data.message;
      }
    }).error(function(response) {
      $scope.internalError();
    });
  } 

  function selectPassword(e) {
      $scope.highlight(e);
      $scope.validatePassword();
  }

  function cancelLogin() {
    $scope.error = "";
    $scope.id = "";
    $scope.username = "";
    $scope.enter_pass = false;
  }

  /**
  * Sends a reset code to the valid email
  *
  * Params: username - the username
  */
  function studentForgotPassword() {
    $scope.error = "";
    $scope.user_type = "Student";

    $scope.ui_block();
    apiService.forgotPassword($scope.username, $scope.user_type).success(function(response) {
      if(response.status == 200) {
        if(response.errors) {
          $scope.errorHandler(response.errors);
        } else if(response.data){
          $scope.email = response.data.email;
          $scope.sent = true;
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
    $scope.resend = true;
    $scope.username = (!isStringNullorEmpty($scope.username)) ? $scope.username : $("input[name='username']").val(); 
    $scope.studentForgotPassword();
  }

  function studentValidateCode(code) {
    $scope.error = "";
    $scope.code = code;
    $scope.user_type = "Student";
    $scope.email = ($scope.email) ? $scope.email : $("input[name='username']").val();

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

  function validateRegistration(reg, terms) {
    $scope.error = "";
    $scope.terms = angular.copy(terms);

    var has_empty = highlight_empty('form_registation');
    if($scope.e_error || $scope.u_error) {
      $scope.error = "";
      $("html, body").animate({ scrollTop: 320 }, "slow");
    } else if (has_empty) {
      $scope.error = "Please fill in required fields";
      $("html, body").animate({ scrollTop: 0 }, "slow");
    } else {
      if($scope.terms) {
        $scope.reg = reg;
        
        if($scope.reg) {
          $scope.reg.birth_date = $("input[name='birth_date']").val();
          $scope.reg.school_code = -1;
        }
        
        $scope.disabled = true;
        $scope.ui_block();
        apiService.validateRegistration($scope.reg).success(function(response) {
          if(response.status == 200) {
            if(response.errors) {
              $scope.errorHandler(response.errors);
              $("#" + $scope.error_object.field).addClass("required-field");
            } else if(response.data){
              $scope.success = true;
              $scope.email = $scope.reg.email;
            }
          }

          $scope.disabled = false;
          $scope.ui_unblock();
        }).error(function(response) {
          $scope.disabled = false;
          $scope.internalError();
          $scope.ui_unblock();
        });
      } else {
        $scope.error = "Please accept the terms and conditions";
        $("html, body").animate({ scrollTop: 0 }, "slow");
      }
    }
  }

  function resendStudentConfirmation() {
    $scope.error = "";
    $scope.user_type = "Student";
    $scope.email = (!isStringNullorEmpty($scope.email)) ? $scope.email : $("input[name='email']").val();

    $scope.ui_block();
    apiService.resendConfirmation($scope.email, $scope.user_type).success(function(response) {
      if(response.status == 200) {
        if(response.errors) {
          $scope.errorHandler(response.errors);
        } else if(response.data) {
          $scope.resent = true;
        }
      }
      $scope.ui_unblock();
    }).error(function(response) {
      $scope.internalError();
      $scope.ui_unblock();
    });
  }

  function confirmStudentRegistration() {
    $scope.error = "";
    $scope.user_type = "Student";
    $scope.email = $("input[name='email']").val();
    $scope.confirmation_code = $("input[name='confirmation_code']").val();

    $scope.ui_block();
    apiService.confirmCode($scope.email, $scope.confirmation_code, $scope.user_type).success(function(response) {
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
    $scope.error = "";

    apiService.clientLogin($scope.username, $scope.password, $scope.role).success(function(response) {
      if(response.status == 200) {
        if(response.errors) {
          $scope.errorHandler(response.errors);
        } else if(response.data) {
          $("input[name='user_data']").val(JSON.stringify(response.data));
          $("#login_form").submit();  
        }
      } else if(response.status == 202) {
        $scope.error = response.data.message;
      }
    }).error(function(response) {
      $scope.internalError();
    });
  }

  function clientForgotPassword() {
    $scope.error = "";
    $scope.user_type = "Client";

    $scope.ui_block();
    apiService.forgotPassword($scope.username, $scope.user_type).success(function(response) {
      if(response.status == 200) {
        if(response.errors) {
          $scope.errorHandler(response.errors);
        } else if(response.data){
          $scope.email = response.data.email;
          $scope.sent = true;
        } 
      }

      $scope.ui_unblock();
    }).error(function(response) {
      $scope.internalError();
      $scope.ui_unblock();
    });
  }

  function clientResendCode() {
    $scope.resend = true;
    $scope.username = (!isStringNullorEmpty($scope.username)) ? $scope.username : $("input[name='username']").val(); 
    $scope.clientForgotPassword();
  }

  function clientValidateCode(code) {
    $scope.error = "";
    $scope.code = code;
    $scope.user_type = "Client";
    $scope.email = ($scope.email) ? $scope.email : $("input[name='username']").val();

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
    $scope.error = "";

    if($scope.new_password == $scope.confirm_password) {
      var reset_code = $("input[name='reset_code']").val();
      var id = $("input[name='id']").val();

      $scope.ui_block();
      apiService.resetClientPassword(id, reset_code, $scope.new_password).success(function(response) {
        if(response.status == 200) {
          if(response.errors) {
            $scope.errorHandler(response.errors);
          } else if(response.data) {
            $scope.success = true;
          }
        }

        $scope.ui_unblock();
      }).error(function(response) {
        $scope.internalError();
        $scope.ui_unblock();
      });
    } else {
      $scope.error = "Password does not match";
      $("html, body").animate({ scrollTop: 0 }, "slow");
    }
  }

  function selectRole(role) {
    $scope.principal = false;
    $scope.teacher = false;
    $scope.parent = false;

    $scope.reg = ($scope.reg) ? $scope.reg: {} ;

    switch(role) {
      case "user_principal"  :
        $scope.principal = true;
        $scope.reg.client_role = "Principal";
        break;
      case "user_teacher"   :
        $scope.teacher = true;
        $scope.reg.client_role = "Teacher";
        break;
      case "user_parent" :
        $scope.parent = true;
        $scope.reg.client_role = "Parent";
        break;
      default:
        break;
    }
  }

  function registerClient(reg, term) {
    $scope.errors = false;
    $scope.reg = reg;

    var has_empty = highlight_empty('form_registation');
    if($scope.e_error || $scope.u_error) {
      $("html, body").animate({ scrollTop: 320 }, "slow");
    } else if (has_empty) {
      $scope.errors = ["Please fill in required fields"];
      $("html, body").animate({ scrollTop: 0 }, "slow");
    } else if($scope.reg.password != $scope.reg.confirm_password) {
      $scope.errors = ["Password does not match."];
      $("html, body").animate({ scrollTop: 0 }, "slow");
    } else if(!term) {
      $scope.errors = ["Please accept the terms and conditions."];
      $("html, body").animate({ scrollTop: 0 }, "slow");
    } else {
      $scope.ui_block();
      apiService.registerClient(reg).success(function(response) {
        if(response.status == 200) {
          if(response.errors) {
            $scope.errors = [];
            angular.forEach(response.errors, function(value, key) {
              $scope.errors[key] = value.message;
            });
          } else if(response.data) {
            $scope.registered = true; 
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
    $scope.error = "";
    $scope.user_type = "Client";
    $scope.email = (!isStringNullorEmpty($scope.email)) ? $scope.email : $("input[name='email']").val();

    $scope.ui_block();
    apiService.resendConfirmation($scope.email, $scope.user_type).success(function(response) {
      if(response.status == 200) {
        if(response.errors) {
          $scope.errorHandler(response.errors);
        } else if(response.data) {
          $scope.resent = true;
        }
      }
      $scope.ui_unblock();
    }).error(function(response) {
      $scope.internalError();
      $scope.ui_unblock();
    });
  }

  function confirmClientRegistration() {
    $scope.error = "";
    $scope.user_type = "Client";
    $scope.confirmation_code = $("input[name='confirmation_code']").val();

    $scope.ui_block();
    apiService.confirmCode($scope.email, $scope.confirmation_code, $scope.user_type).success(function(response) {
      if(response.status == 200) {
        if(response.errors) {
          $scope.errorHandler(response.errors);
        } else if(response.data){
          $scope.success = true;
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


  /** 
   * Login
   */

  $scope.getLoginPassword = function() {
    $scope.id = ($scope.id) ? $scope.id : $scope.user.id;
    apiService.getLoginPassword($scope.id).success(function (response) {
      $scope.image_pass = response.data
      $scope.reset = true;
    }).error(function(response) {
      $scope.error = response.errors.message;
    });
  }

  $scope.getImagePassword = function() {
    apiService.getImagePassword().success(function(response) {
      $scope.image_pass = response.data
      $scope.reset = true;
    }).error(function(response) {
      $scope.error = response.errors.message;
    });
  }

  $scope.validateNewPassword = function() {
    $scope.error = "";

    if($scope.new_password == $scope.image_id) {
      var code = $("input[name='code']").val();
      var id = $("input[name='id']").val();

      $scope.ui_block();
      apiService.resetPassword(id, code, $scope.new_password).success(function(response) {
        if(response.status == 200) {
          if(response.errors) {
            $scope.errorHandler(response.errors);
          } else if(response.data){
            $scope.success = true;
          } 
        }

        $scope.ui_unblock();
      }).error(function(response) {
        $scope.internalError();
        $scope.ui_unblock();
      });
    } else {
      $scope.error = "Password does not match.";
      $("html, body").animate({ scrollTop: 0 }, "slow");
    }
  }

  $scope.getGradeLevel = function() {
    apiService.getGradeLevel().success(function(response) {
      if(response.status == 200) {
        $scope.grades = response.data;
      } else {
        $scope.error = response.data.message;
      }
    }).error(function(response) {
      $scope.error = response.errors.message;
    });
  }

  $scope.showModal = function(id) {
    $scope.show_terms = (id == 'terms_modal') ? true : false;
    $scope.show_policy = (id == 'policy_modal') ? true : false;
    $scope.show = true;


    $("#"+id).modal({
        backdrop: 'static',
        keyboard: false,
        show    : true
    });
  }

  $scope.getUserDetails = function() {
    var user = $('#userdata').val();

    if(angular.isString(user) && user.length > 0) {
      $scope.user = JSON.parse(user);
      $('#userdata').html('');

      if(($scope.user.avatar_id != null && $scope.user.avatar_id != "") && $scope.has_style) {
        
      }
    }
    
  }

  $scope.getAvatarImages = function(change) {
    if(change || $scope.user.avatar_id == null || $scope.user.avatar_id == "") {
      
      apiService.getAvatarImages($scope.user.gender).success(function(response) {
        if(response.status == 200) {
          if(response.errors) {
            $scope.errorHandler(response.errors);
          } else if(response.data){
            $scope.avatars = response.data;
          }
        } else if(response.status == 201) {
          $scope.error = response.data.message;
        } else if(response.status == 202) {
          $scope.error = response.data.message;
        }
      }).error(function(response) {
        $scope.error = response.errors.message;
      });
    } else {
      $scope.has_avatar = true;
    }
  }

  $scope.stepOne = function() {
    $scope.user.avatar_id = "";
    $scope.has_avatar = false;
  }

  $scope.stepTwo = function() {
    if($scope.user.avatar_id != null || $scope.user.avatar_id != "") {
      $scope.has_avatar = false;
    }
  }

  $scope.highlightAvatar = function(e) {
    var target = getTarget(e);

    $("ul.avatar_list li").removeClass('selected');
    $(target).addClass('selected');
    $scope.avatar_id = $(target).find("#avatar_id").val(); 
  }

  $scope.selectAvatar = function() {
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
      } else if(response.status == 201) {
        $scope.error = response.data.message;
      } else if(response.status == 202) {
        $scope.error = response.data.message;
      }
    }).error(function(response) {
      $scope.internalError();
    });
  }

  $scope.setActive = function(active) {
    $scope.error = "";
    $scope.success_msg = "";
    $scope.e_error = false;
    $scope.u_error = false;
    $scope.e_success = false;
    $scope.u_success = false;

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
        $scope.edit = false;
        $("html, body").animate({ scrollTop: 0 }, "slow");
        break;
    }
  }


  /**
  * Profile related controllers
  */
  $scope.editProfile = function() {
    $scope.studentDetails();
    $scope.edit = true;

    $("html, body").animate({ scrollTop: 0 }, "slow");
  }

  function saveProfile(prof) {
    $scope.error = "";
    $scope.success_msg = "";
    var has_empty = highlight_empty('form_profile');

    if($scope.e_error || $scope.u_error) {
      $scope.error = "";
      $("html, body").animate({ scrollTop: 350 }, "slow");
      return;
    } else if (has_empty) {
      $scope.error = "Please fill the required fields"
    } else {
      $scope.prof.school_code = 1;
      $scope.prof.birth_date = $("input[name='birth_date']").val();

      apiService.saveProfile($scope.prof).success(function(response) {
        if(response.status == 200) {
          if(response.errors) {
            $scope.errorHandler(response.errors);
            $("#" + $scope.error_object.field).addClass("required-field");
          } else if(response.data){
            $scope.setActive('index');
            $scope.success = true;
            $scope.success_msg = "Successfully update profile";
          }
        } else if(response.status == 201) {
          $scope.error = response.data.message;
        } else if(response.status == 202) {
          $scope.error = response.data.message;
        }
      }).error(function(response) {
        $scope.internalError();
      });
    }

    $("html, body").animate({ scrollTop: 0 }, "slow");
  }

  $scope.validateCurrentPassword = function() {
    $scope.error = "";

    apiService.validatePassword($scope.user.id, $scope.image_id).success(function(response) {
      if(response.status == 200) {
        if(response.errors) {
          $scope.errorHandler(response.errors);
        } else if(response.data){
          $scope.image_id = "";
          $scope.password_validated = true;
          
          $scope.getImagePassword();
        } 
      } else if(response.status == 202) {
        $scope.locked = true; 
      }
    }).error(function(response) {
        $scope.internalError();
    });
  }

  $scope.selectNewPassword = function() {
    $scope.password_selected = false;
    $scope.error = "";

    if($scope.image_id) {
      $scope.password_selected = true;
      $scope.new_password = $scope.image_id;
      $scope.image_id = "";
      $scope.image_pass = shuffle($scope.image_pass);
      $("ul.form_password li").removeClass('selected');
    } else {
      $scope.error = "Please select a new picture password";
    }

    $("html, body").animate({ scrollTop: 0 }, "slow");
  }

  $scope.undoNewPassword = function() {
    $scope.error = "";
    $scope.image_pass = shuffle($scope.image_pass);
    $scope.password_selected = false;
    $scope.image_id = $scope.new_password;

    $("ul.form_password li").removeClass("selected");
    $("input[value='"+$scope.new_password+"']").closest("li").addClass("selected");

    $("html, body").animate({ scrollTop: 0 }, "slow");
  }

  $scope.confirmNewPassword = function() {
    $scope.error = "";

    if($scope.image_id == $scope.new_password) {
        apiService.changePassword($scope.user.id, $scope.image_id, $scope.user.access_token).success(function(response) {
          if(response.status == 200) {
            if(response.errors) {
              $scope.errorHandler(response.errors);
            } else if(response.data){
              $scope.password_confirmed = true;
            } 
          } else if(response.status == 201) {
            $scope.error = response.errors.message;
          }
        }).error(function(response) {
          $scope.internalError();
        });
    } else {
      $scope.error = "Password does not match"
      $("html, body").animate({ scrollTop: 0 }, "slow");
    }
  }

  $scope.studentDetails = function() {
    apiService.studentDetails($scope.user.id, $scope.user.access_token).success(function(response) {
      if(response.status == 200) {
        $scope.prof = response.data[0];
        $scope.prof.access_token = $scope.user.access_token;
        $scope.user = $scope.prof;

        $scope.prof.birth = $scope.prof.birth_date;
      }
    }).error(function(response) {
      $scope.error = response.errors.message;
    });
  }
};