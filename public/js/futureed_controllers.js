var controllers = angular.module('futureed.controllers', []);

  controllers.controller('futureedController', function($scope, $location, loginAPIService) {
      $scope.redirect = function(url) {
        window.location.href = url;
      }

      $scope.validateUser = function(username) {
        $scope.username = angular.copy(username);
        $scope.error = "";

        loginAPIService.validateUser($scope.username).success(function (response) {
            if(response.status == 200) {
              $scope.id = response.data.id;
              $("input[name='id']").val($scope.id);
              $("#login_form").submit();
            } else {
              var data = response.data;
              if(data.error_code == 202) {
                if(data.message == "Account Locked") {
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
              $scope.error = response.data;
            }
        });
      }

      $scope.highlight = function($event) {
        $("ul.form_password li").removeClass('selected');
        $($event.currentTarget).addClass('selected');
        $scope.image_id = $($event.currentTarget).find("#image_id").val();
      }

      $scope.validatePassword = function () {
        loginAPIService.validatePassword($scope.id, $scope.image_id).success(function(response) {
          if(response.status == 200) {
            $("#response").val(response.data);
            $("#password_form").submit();
          } else if(response.status == 202) {
            if(response.data.message == "Account Locked") {
              $scope.locked = true;
            } else {
              $scope.error = "Password does not match.";
            } 
          }
        }).error(function(response) {
          
        });
      }

      $scope.forgotPassword = function(username) {
        $scope.error = "";
        $scope.username = angular.copy(username);

        loginAPIService.forgotPassword($scope.username).success(function(response) {
          if(response.status == 200) {
            $("#forgot_pass_form").submit();
          } else {
            $scope.error = response.data.message;
          }
        }).error(function(response) {
          $scope.error = response.data.message;
        });
      }

      $scope.setDisplay = function(email) {
        if(email != '') {
          $scope.title = "";
          return false;
        }

        $scope.title = "Email Sent";
        return true;
      }

      $scope.getImagePassword = function() {
        $scope.id = $("input[name='id']").val();
        $scope.selected_image_id = $("input[name='selected_image_id']").val();

        loginAPIService.getImagePassword($scope.id).success(function (response) {
          $scope.image_pass = response.data
          $scope.reset = true;
        }).error(function(response) {

        });
      }

      $scope.highlight = function($event, array) {
        $("ul.form_password li").removeClass('selected');
        $($event.currentTarget).addClass('selected');
        $scope.image_id = $($event.currentTarget).find("#image_id").val();
      }

      $scope.validatePassword = function () {
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
        $("#success_form").submit();
        return;

        $scope.error = "";
        $scope.code = angular.copy(code);
        $scope.email = ($scope.email) ? $scope.email : $("input[name='email']").val();

        loginAPIService.validateCode($scope.code, $scope.email).success(function(response) {
          if(response.status == 200) {
            $("input[name='user_id']").val(response.data.id);
            $("#success_form").submit();
          } else {
            $scope.error = response.data.message;
          }
        }).error(function(response) {
          $scope.error = response.data.message;
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

      $scope.validateNewPassword = function() {
        $scope.error = "";

        if($scope.new_password == $scope.image_id) {
          var code = $("input[name='reset_code']").val();
          loginAPIService.resetPassword($scope.id, code, $scope.new_password).success(function(response) {
            $("#reset_password_form").submit();
          }).error(function(response) {

          });
        } else {
          $scope.error = "Password does not match.";
        }
      }

      $scope.updateBirthday = function(asd) {
        console.log(typeof $scope.reg != undefined);
        console.log(asd);

        if(typeof $scope.reg != undefined) {
          $scope.reg.birthday = asd;
        } else {
          $scope.reg = {
            birthday : asd
          }
        }
      }

      $scope.alert = function(data, reg) {
        $scope.reg.birthday = $scope.data.date;
      }

      $scope.validateRegistration = function(registration, terms) {
        $scope.error = "";
        $scope.terms = angular.copy(terms);

        if($scope.terms) {
          $scope.registration = angular.copy(registration);
          // $scope.registration.birthday = $("input[name='birthday']").val();
          // loginAPIService.validateRegistration($scope.registration).success(function(response) {
          //   if(response.status == 200) {
          //     if(response.errors) {
          //       $scope.error = response.errors.message;
          //     } else {
                $scope.success = true;
                   $scope.email = $scope.registration.email;
              // }
            // } else {
              // $scope.error = response.data.message;
            // }
          // }).error(function(response) {
          //   $scope.error = response.data.message;
          // });
        } else {
          $scope.error = "Please accept the terms and conditions.";
        }
      }

      $scope.getUserDetails = function() {
        $scope.user = JSON.parse($('#userdata').val());
        $('#userdata').html('');
      }
    });