var controllers = angular.module('futureed.controllers', []);

  controllers.controller('futureedController', function($scope, $location, loginAPIService) {
      $scope.error = "";

      $scope.errorHandler = function(errors) {
        $scope.error_object = (typeof errors[0] != "undefined") ? errors[0] : errors;
        $scope.error = $scope.error_object.message;
        return $scope.error_object.error_code;
      }

      $scope.internalError = function() {
        $scope.error = "Internal Server Error.";
      }

      $scope.validateUser = function() {
        $scope.error = "";

        loginAPIService.validateUser($scope.username).success(function (response) {
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

      $scope.highlight = function() {
        var e = window.event || e;
        var targ = e.currentTarget || e.srcElement;

        $("ul.form_password li").removeClass('selected');
        $(targ).addClass('selected');

        $scope.image_id = $(event.currentTarget).find("#image_id").val();
      }

      $scope.selectPassword = function(event) {
          $scope.highlight();
          $scope.validatePassword();
      }

      $scope.forgotPassword = function(username) {
        $scope.error = "";
        $scope.disabled = true;
        $scope.username = username;

        loginAPIService.forgotPassword($scope.username).success(function(response) {
          if(response.status == 200) {
            if(response.errors) {
              $scope.errorHandler(response.errors);
            } else if(response.data){
              $scope.email = response.data.email;
              $scope.sent = true;
            } 
          } else if(response.status == 201) {
            $scope.error = response.data.message;
          } else if(response.status == 202) {
            $scope.error = response.data.message;
          }

          $scope.disabled = false;
        }).error(function(response) {
          $scope.disabled = false;
          $scope.internalError();
        });
      }

      $scope.resendCode = function() {
        $scope.resend = true;
        $scope.email = ($scope.email) ? $scope.email : $("input[name='username']").val();        
        $scope.forgotPassword($scope.email);
      }

      $scope.getLoginPassword = function() {
        $scope.id = ($scope.id) ? $scope.id : $scope.user.id;
        loginAPIService.getLoginPassword($scope.id).success(function (response) {
          $scope.image_pass = response.data
          $scope.reset = true;
        }).error(function(response) {
          $scope.error = response.errors.message;
        });
      }

      $scope.getImagePassword = function() {
        loginAPIService.getImagePassword().success(function (response) {
          $scope.image_pass = response.data
          $scope.reset = true;
        }).error(function(response) {
          $scope.error = response.errors.message;
        });
      }

      $scope.validatePassword = function () {
        $scope.error = "";

        loginAPIService.validatePassword($scope.id, $scope.image_id).success(function(response) {
          if(response.status == 200) {
            if(response.errors) {
              $scope.errorHandler(response.errors);
            } else if(response.data){
              $("#response").val(JSON.stringify(response.data));
              $("#password_form").submit();
            } 
          } else if(response.status == 202) {
            $scope.error = response.data.message;
          }
        }).error(function(response) {
          $scope.internalError();
        });
      } 

      $scope.validateCode = function(code) {
        $scope.error = "";
        $scope.disabled = true;
        $scope.code = code;
        $scope.email = ($scope.email) ? $scope.email : $("input[name='username']").val();

        loginAPIService.validateCode($scope.code, $scope.email).success(function(response) {
          if(response.status == 200) {
            if(response.errors) {
              $scope.errorHandler(response.errors);
            } else if(response.data){
              $("input[name='id']").val(response.data.id);
              $("#success_form").submit();
            } 
          } else if(response.status == 201) {
            $scope.error = response.data.message;
          } else if(response.status == 202) {
            $scope.error = response.data.message;
          }

          $scope.disabled = false;
        }).error(function(response) {
          $scope.disabled = false;
          $scope.internalError();
        });
      }

      $scope.confirmCode = function(code) {
        $scope.error = "";
        $scope.disabled = true;
        $scope.code = angular.copy(code);
        $scope.email = ($scope.email) ? $scope.email : $("input[name='email']").val();

        loginAPIService.confirmCode($scope.code, $scope.email).success(function(response) {
          if(response.status == 200) {
            if(response.errors) {
              $scope.errorHandler(response.errors);
            } else if(response.data){
              $("input[name='id']").val(response.data.id);
              $("input[name='email']").val($scope.email);
              $("#success_form").submit();
            } 
          } else if(response.status == 201) {
            $scope.error = response.data.message;
          } else if(response.status == 202) {
            $scope.error = response.data.message;
          }

          $scope.disabled = false;
        }).error(function(response) {
          $scope.disabled = false;
          $scope.internalError();
        });
      }

      $scope.validateNewPassword = function() {
        $scope.error = "";
        $scope.disabled = true;

        if($scope.new_password == $scope.image_id) {
          var code = $("input[name='code']").val();
          var id = $("input[name='id']").val();

          loginAPIService.resetPassword(id, code, $scope.new_password).success(function(response) {
            if(response.status == 200) {
              if(response.errors) {
                $scope.errorHandler(response.errors);
              } else if(response.data){
                $("#reset_password_form").submit();
              } 
            } else if(response.status == 201) {
              $scope.error = response.data.message;
            } else if(response.status == 202) {
              $scope.error = response.data.message;
            }

            $scope.disabled = false;
          }).error(function(response) {
            $scope.disabled = false;
            $scope.internalError();
          });
        } else {
          $scope.error = "Password does not match.";
          $scope.disabled = false;
        }

        $("html, body").animate({ scrollTop: 0 }, "slow");
      }

      $scope.getGradeLevel = function() {
        loginAPIService.getGradeLevel().success(function(response) {
          if(response.status == 200) {
            $scope.grades = response.data;
          } else {
            $scope.error = response.data.message;
          }
        }).error(function(response) {
          $scope.error = response.errors.message;
        });
      }

      $scope.checkAvailability = function(username) {
        $scope.error = "";

        loginAPIService.validateUsername(username).success(function(response) {
          if(response.status == 200) {
            if(response.errors) {
              var error_code = $scope.errorHandler(response.errors);
              if(error_code == 2001) {
                $scope.error = "";
                $scope.u_error = false;
              } else {
                $scope.u_error = true;
              }
            } else if(response.data) {
              if($scope.user && (response.data.id == $scope.user.id)) {
                $scope.u_error = false;
              } else {
                $scope.u_error = true;
                $scope.error = "Username already exist";  
              }
            }
          }
        }).error(function(response) {
          $scope.internalError();
        });
      }

      $scope.checkEmailAvailability = function(email) {
        $scope.error = "";
        
        loginAPIService.validateEmail(email).success(function(response) {
          if(response.status == 200) {
            if(response.errors) {
              var error_code = $scope.errorHandler(response.errors);
              if(error_code == 2002) {
                $scope.error = "";
                $scope.e_error = false;
              } else {
                $scope.e_error = true;
              }
            } else if(response.data) {
              if($scope.user && (response.data.id == $scope.user.id)) {
                $scope.e_error = false;
              } else {
                $scope.e_error = true;
                $scope.error = "Email already exist";  
              }
            }
          }
        }).error(function(response) {
          $scope.internalError();
        });
      }

      $scope.validateRegistration = function(reg, terms) {
        $scope.error = "";
        $scope.terms = angular.copy(terms);

        var has_empty = highlight_empty('form_registation');
        if (has_empty) {
          $scope.error = "Please fill the required fields"
        } else {
          if($scope.terms) {
            $scope.reg = reg;
            
            if($scope.reg) {
              $scope.reg.birth_date = $("input[name='birth_date']").val();
              $scope.reg.school_code = -1;
            }
            
            $scope.disabled = true;
            loginAPIService.validateRegistration($scope.reg).success(function(response) {
              if(response.status == 200) {
                if(response.errors) {
                  $scope.errorHandler(response.errors);
                  $("#" + $scope.error_object.field).addClass("required-field");
                } else if(response.data){
                  $scope.success = true;
                  $scope.email = $scope.reg.email;
                } 
              } else if(response.status == 201) {
                $scope.error = response.data.message;
              } else if(response.status == 202) {
                $scope.error = response.data.message;
              }

              $scope.disabled = false;
            }).error(function(response) {
              $scope.disabled = false;
              $scope.internalError();
            });
          } else {
            $scope.error = "Please accept the terms and conditions";
          }
        }

        $("html, body").animate({ scrollTop: 0 }, "slow");
      }

      $scope.getUserDetails = function() {
        $scope.user = JSON.parse($('#userdata').val());
        $('#userdata').html('');

        if(($scope.user.avatar_id != null && $scope.user.avatar_id != "") && $scope.has_style) {
          $scope.done = true;
        }
      }

      $scope.getAvatarImages = function(change) {
        if(change || $scope.user.avatar_id == null || $scope.user.avatar_id == "") {
          
          loginAPIService.getAvatarImages($scope.user.gender).success(function(response) {
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

      $scope.highlightAvatar = function($event) {
        var e = window.event || e;
        var targ = e.currentTarget || e.srcElement;

        $("ul.avatar_list li").removeClass('selected');
        $(targ).addClass('selected');
        $scope.avatar_id = $($event.currentTarget).find("#avatar_id").val(); 
      }

      $scope.selectAvatar = function() {
        loginAPIService.selectAvatar($scope.user.id, $scope.avatar_id).success(function(response) {
          if(response.status == 200) {
            if(response.errors) {
              $scope.errorHandler(response.errors);
            } else if(response.data){
              $scope.user.avatar_id = response.data.id;
              $scope.user.avatar = response.data.url;
            
              $scope.session_user = $scope.user;
              $scope.has_avatar = true;
              loginAPIService.updateUserSession($scope.user).success(function(response) {
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

      $scope.close = function() {
        $scope.done = true;
      }

      $scope.setActive = function(active) {
        $scope.error = "";

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

      $scope.saveProfile = function(prof) {
        $scope.error = "";

        var has_empty = highlight_empty('form_registation');
        if (has_empty) {
          $scope.error = "Please fill the required fields"
        } else {
          $scope.prof.school_code = 1;
          $scope.prof.birth_date = $("input[name='birth_date']").val();

          loginAPIService.saveProfile($scope.prof).success(function(response) {
            if(response.status == 200) {
              if(response.errors) {
                $scope.errorHandler(response.errors);
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
      }

      $scope.validateCurrentPassword = function() {
        $scope.error = "";

        loginAPIService.validatePassword($scope.user.id, $scope.image_id).success(function(response) {
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
            loginAPIService.changePassword($scope.user.id, $scope.image_id, $scope.user.access_token).success(function(response) {
              if(response.status == 200) {
                $scope.password_confirmed = true;
              }
            }).error(function(response) {

            });
        } else {
          $scope.error = "Password does not match"
          $("html, body").animate({ scrollTop: 0 }, "slow");
        }
      }

      $scope.studentDetails = function() {
        loginAPIService.studentDetails($scope.user.id, $scope.user.access_token).success(function(response) {
          if(response.status == 200) {
            $scope.prof = response.data[0];
            $scope.prof.access_token = $scope.user.access_token;
            $scope.user = $scope.prof;
          }
        }).error(function(response) {
          $scope.error = response.errors.message;
        });
      }
    });