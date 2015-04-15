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

      $scope.getImagePassword = function() {
        // $scope.id = $("input[name='id']").val();
        $scope.id = "3";

        loginAPIService.getImagePassword($scope.id).success(function (response) {
          $scope.imagePass = response.data
        }).error(function(response) {

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
            $("input[name='response']").val(response.data.email);
            $("#redirect_form").submit();
          } else {
            $scope.error = response.data.message;
          }
        }).error(function(response) {
          $scope.error = response.data.message;
        });
      }

      $scope.setDisplay = function(email) {
        if(email != '') {
          $scope.title = "Enter Reset Code";
          return false;
        }

        $scope.title = "Email Sent";
        return true;
      }

      $scope.getImagePassword = function() {
        $scope.id = $("input[name='id']").val();

        loginAPIService.getImagePassword($scope.id).success(function (response) {
          $scope.imagePass = response.data
        }).error(function(response) {

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
        $scope.email = $("input[name='email']").val();

        loginAPIService.validateCode($scope.code, $scope.email).success(function(response) {
          if(response.status == 200) {
            $("input[name='response']").val(response.data);
            $("#success_form").submit();
          } else {
            $scope.error = response.data.message;
          }
        }).error(function(response) {
          $scope.error = response.data.message;
        });
      }

      $scope.storeNewPassword = function() {
        $("input[name='selected_image_id']").val($scope.image_id);
        $("#reset_password_form").submit();
      }

      $scope.updateBirthdate = function(reg, birthday) {
        $scope.reg.birthday = $("input[name='birthday']").val();
      }

      $scope.validateRegistration = function(registration, terms) {
        $scope.error = "";
        $scope.terms = angular.copy(terms);
        if($scope.terms) {
          $scope.registration = angular.copy(registration);
        
          loginAPIService.validateRegistration($scope.registration).success(function(response) {
            if(response.status == 200) {
              if(response.errors) {
                $scope.error = response.errors.message;
              }
            } else {
              $scope.error = response.data.message;
            }
          }).error(function(response) {
            $scope.error = response.data.message;
          });
        } else {
          $scope.error = "Please accept the terms and conditions.";
        }
        
      }

      $scope.getUserDetails = function() {
        var user = JSON.parse($('#userdata').val());
        $('#userdata').html('');
      }
    });