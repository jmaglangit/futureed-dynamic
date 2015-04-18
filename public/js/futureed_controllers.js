var controllers = angular.module('futureed.controllers', []);

  controllers.controller('futureedController', function($scope, $location, loginAPIService) {
      $scope.error = "";

      $scope.validateUser = function(username) {
        $scope.username = angular.copy(username);
        $scope.error = "";

        loginAPIService.validateUser($scope.username).success(function (response) {
            if(response.status == 200) {
              $scope.id = response.data.id;
              $("input[name='id']").val($scope.id);
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

      $scope.highlight = function($event) {
        if($("ul.form_password li").length > 0) {
          $("ul.form_password li").removeClass('selected');
          $($event.currentTarget).addClass('selected');
          $scope.image_id = $($event.currentTarget).find("#image_id").val();  
        } else {
          $("ul.avatar_list li").removeClass('selected');
          $($event.currentTarget).addClass('selected');
          $scope.avatar_id = $($event.currentTarget).find("#avatar_id").val();  
        }
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
          $scope.error = response.errors.message;
        });
      }

      $scope.getLoginPassword = function() {
        $scope.id = $("input[name='id']").val();
        $scope.selected_image_id = $("input[name='selected_image_id']").val();

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

      $scope.storeNewPassword = function(array) {
        $scope.error = "";

        if($scope.image_id) {
          $("ul.form_password li").removeClass('selected');
          $scope.new_password = $scope.image_id;
          $scope.image_pass = shuffle($scope.image_pass);
          $scope.image_id = "";
          $scope.confirm = true;
        } else {
          $scope.error = "Select a new password."
        }
      }

      $scope.undoNewPassword = function() {
        $("ul.form_password li").removeClass('selected');
        $scope.image_id = "";
        $scope.new_password = "";
        $scope.image_pass = shuffle($scope.image_pass);
        $scope.confirm = false;
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
          console.log(response.data);

          if(response.status == 200) {
            $scope.grades = response.data;
          } else {
            $scope.error = response.data.message;
          }
        }).error(function(response) {
          $scope.error = response.errors.message;
        });
      }

      $scope.validateRegistration = function(registration, terms) {
        $scope.error = "";
        $scope.terms = angular.copy(terms);

        if($scope.terms) {
          $scope.registration = angular.copy(registration);
          
          if($scope.registration) {
            $scope.registration.birth_date = $("input[name='birth_date']").val();
          $scope.registration.school_code = "na";
          }
          
          loginAPIService.validateRegistration($scope.registration).success(function(response) {
            if(response.status == 200) {
              if(response.errors) {
                $scope.error = response.errors.message;
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
          $scope.error = "Please accept the terms and conditions.";
        }
      }

      $scope.getUserDetails = function() {
        $scope.user = JSON.parse($('#userdata').val());
        $('#userdata').html('');

        if(($scope.user.avatar_id != null && $scope.user.avatar_id != "") && $scope.has_style) {
          $scope.done = true;
        }
      }

      $scope.getAvatarImages = function() {
        if($scope.user.avatar_id == null || $scope.user.avatar_id == "") {
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

      $scope.selectAvatar = function() {
        loginAPIService.selectAvatar($scope.user.id, $scope.avatar_id).success(function(response) {
          if(response.status == 200) {
            $scope.has_avatar = true;
            $scope.user.avatar_id = $scope.avatar_id;
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
    });

function shuffle(array) {
  var m = array.length, t, i;
    // While there remain elements to shuffle
    while (m) {
      // Pick a remaining element…
      i = Math.floor(Math.random() * m--);

      // And swap it with the current element.
      t = array[m];
      array[m] = array[i];
      array[i] = t;
    }

  return array;
}