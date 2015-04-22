var controllers = angular.module('futureed.controllers', []);

  controllers.controller('futureedController', function($scope, $location, loginAPIService) {
      $scope.error = "";
      $scope.view = "";

      $scope.validateUser = function(username) {
        $scope.username = angular.copy(username);
        $scope.error = "";

        loginAPIService.validateUser($scope.username).success(function (response) {
            if(response.status == 200) {
              $scope.id = response.data.id;
              $scope.getLoginPassword();
              $scope.enter_pass = true;
            } else {
              var data = response.data;
              if(data.error_code == 202) {
                if(data.message == "Account Locked") {
                  $scope.error = "";
                  $scope.locked = true;
                } else {
                  $scope.error = data.message;
                }
              } else {
                $scope.error = data.message;
              }
            }
        }).error(function(response) {
            if(response.status == 422) {
              $scope.error = "Username should not be empty."
            } else {
              $scope.error = response.errors.message;
            }
        });
      }

      $scope.highlight = function() {
        $("ul.form_password li").removeClass('selected');
        $(event.currentTarget).addClass('selected');

        $scope.image_id = $(event.currentTarget).find("#image_id").val();
      }

      $scope.selectPassword = function(event) {
          $scope.highlight();
          $scope.validatePassword();
      }

      $scope.forgotPassword = function(username) {
        $scope.error = "";
        $scope.username = angular.copy(username);

        loginAPIService.forgotPassword($scope.username).success(function(response) {
          if(response.status == 200) {
            $("input[name='email']").val(response.data.email);
            $("#forgot_pass_form").submit();
          } else {
            $scope.error = response.data.message;
          }
        }).error(function(response) {
          $scope.error = response.data.message;
        });
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
            $("#response").val(JSON.stringify(response.data));
            $("#password_form").submit();
          } else if(response.status == 202) {
            if(response.data.message == "Account Locked") {
              $scope.locked = true;
            } else {
              $scope.error = "Password does not match.";
            }
          }
        });
      } 

      $scope.validateCode = function(code) {
        $scope.error = "";
        $scope.code = angular.copy(code);
        $scope.email = ($scope.email) ? $scope.email : $("input[name='email']").val();

        loginAPIService.validateCode($scope.code, $scope.email).success(function(response) {
          if(response.status == 200) {
            $("input[name='id']").val(response.data.id);
            $("#success_form").submit();
          } else {
            $scope.error = response.data.message;
          }
        }).error(function(response) {
          $scope.error = response.errors.message;
        });
      }

      $scope.confirmCode = function(code) {
        $scope.error = "";
        $scope.code = angular.copy(code);
        $scope.email = ($scope.email) ? $scope.email : $("input[name='email']").val();

        loginAPIService.confirmCode($scope.code, $scope.email).success(function(response) {
          if(response.status == 200) {
            $("input[name='id']").val(response.data.id);
            $("input[name='email']").val($scope.email);
            $("#success_form").submit();
          } else {
            $scope.error = response.data.message;
          }
        }).error(function(response) {
          $scope.error = response.errors.message;
        });
      }

      $scope.validateNewPassword = function(reg) {
        $scope.error = "";

        if($scope.new_password == $scope.image_id) {
          var code = $("input[name='code']").val();
          $scope.id = $("input[name='id']").val();
          loginAPIService.resetPassword($scope.id, code, $scope.new_password).success(function(response) {
            $("#reset_password_form").submit();
          }).error(function(response) {
            $scope.error = response.errors.message;
          });
        } else {
          $scope.error = "Password does not match.";
        }
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

      $scope.checkAvailability = function(username, field) {
          loginAPIService.validateUser(username).success(function(response) {
            if(response.status == 200 || response.data.message == "Invalid Username") {
              if(field == 'username') {
                $scope.u_error = true;
              } else if(field == 'email') {
                $scope.e_error = true;
              }
            } else {
              if(field == 'username') {
                $scope.u_error = false;
              } else if(field == 'email') {
                $scope.e_error = false;
              }
            }
          }).error(function(response) {
            $scope.error = response.errors.message;
          });
      }

      $scope.validateRegistration = function(registration, terms) {
        $scope.error = "";
        $scope.terms = angular.copy(terms);

        var has_empty = highlight_empty('form_registation');
        if (has_empty) {
          $scope.error = "Please fill the required fields"
        } else {
          if($scope.terms) {
            $scope.registration = angular.copy(registration);
            
            if($scope.registration) {
              $scope.registration.birth_date = $("input[name='birth_date']").val();
            $scope.registration.school_code = -1;
            }
            
            loginAPIService.validateRegistration($scope.registration).success(function(response) {
              if(response.status == 200) {
                if(response.errors) {
                  $scope.error = "Please fill the required fields";
                } else {
                  $scope.success = true;
                  $scope.email = $scope.registration.email;
                }
              } else {
                $scope.error = response.data.message;
              }
            }).error(function(response) {
              $scope.error = response.errors.message;
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
              $scope.avatars = response.data;
            } else {
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
        $("ul.avatar_list li").removeClass('selected');
        $($event.currentTarget).addClass('selected');
        $scope.avatar_id = $($event.currentTarget).find("#avatar_id").val(); 
      }

      $scope.selectAvatar = function() {
        loginAPIService.selectAvatar($scope.user.id, $scope.avatar_id).success(function(response) {
          if(response.status == 200) {
            $scope.has_avatar = true;
            $scope.user.avatar_id = response.data.id;
            $scope.user.avatar = response.data.url;
          } else {
            $scope.error = response.data.message;
          }
        }).error(function(response) {
          $scope.error = "Please select an avatar";
        });
      }

      $scope.close = function() {
        $scope.done = true;
      }

      $scope.setActive = function(active) {
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
            break;
        }
      }


      /**
      * Profile related controllers
      */
      $scope.editProfile = function() {
        $scope.edit = true;

        $("html, body").animate({ scrollTop: 0 }, "slow");
      }

      $scope.saveProfile = function() {
        $scope.edit = false;
        $("html, body").animate({ scrollTop: 0 }, "slow"); 
      }

      $scope.validateCurrentPassword = function() {
        $scope.error = "";

        loginAPIService.validatePassword($scope.id, $scope.image_id).success(function(response) {
          if(response.status == 200) {
            $scope.password_validated = true;
            $scope.image_id = "";
            $scope.getImagePassword();
          }
        }).error(function(response) {
          $scope.error = response.errors.message;
        });

        $("html, body").animate({ scrollTop: 0 }, "slow");
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
        $scope.image_pass = shuffle($scope.image_pass);
        $scope.password_selected = false;
        $scope.image_id = $scope.new_password;

        $("ul.form_password li").removeClass("selected");
        $("input[value='"+ $scope.new_password+"']").closest("li").addClass("selected");
      }

      $scope.confirmNewPassword = function() {
        $scope.error = "";

        if($scope.image_id == $scope.new_password) {
            loginAPIService.changePassword($scope.user.id, $scope.image_id, $scope.user.access_token).success(function(response) {
              $scope.password_confirmed = true;
            }).error(function(response) {

            });
        } else {
          $scope.error = "Password does not match"
        }

        $("html, body").animate({ scrollTop: 0 }, "slow");
      }

      $scope.studentDetails = function() {
        loginAPIService.studentDetails($scope.user.id, $scope.user.access_token).success(function(response) {
          if(response.status == 200) {
            $scope.user = response.data[0];
            $scope.prof = $scope.user;
          }
        }).error(function(response) {
          $scope.error = response.errors.message;
        });
      }
    });