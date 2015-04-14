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
      $scope.username = angular.copy(username);
      loginAPIService.forgotPassword($scope.username).success(function(response) {

      }).error(function(response) {

      });
    }

    $scope.validateCode = function(code, email) {
      $scope.code = angular.copy(code);
      $scope.email = angular.copy(email);
    }

    $scope.validateRegistration = function(registration) {

    }
});
   