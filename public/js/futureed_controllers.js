var controllers = angular.module('futureed.controllers', []);
  //DRIVERS CONTROLLER
  controllers.controller('driversController', function($scope, futureedAPIservice) {
    $scope.filterName = null;
    $scope.driversList = [];
    $scope.searchFilter = function (driver) {
        var keyword = new RegExp($scope.filterName, 'i');
        return !$scope.filterName || keyword.test(driver.Driver.givenName) || keyword.test(driver.Driver.familyName);
    };

    ergastAPIservice.getDrivers().success(function (response) {
        //Dig into the response to get the relevante data
        $scope.driversList = response.MRData.StandingsTable.StandingsLists[0].DriverStandings;
    });
  });

  controllers.controller('futureedController', function($scope, $location, loginAPIService) {
      $scope.redirect = function(url) {
        window.location.href = url;
      }

      $scope.validateUser = function(username) {
      $scope.username = angular.copy(username);
      $scope.error = "";

      loginAPIService.validateUser($scope.username).success(function (response) {
          if(response.status == 200) {
            $scope.id = response.data;
            $("input[name='id']").val($scope.id);
            $("#loginForm").submit();
          } else {
            console.log(response.data);
            var data = response.data;
            if(data.error_code == 202) {
              if(data.message == "Account Locked") {
                $scope.locked = true;
              }
            } else {
              $scope.error = response.data.message;
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
      // $scope.id = $("#id").val();
      $scope.id = "3";

      loginAPIService.getImagePassword($scope.id).success(function (response) {
        $scope.imagePass = response.data
        console.log($scope.imagePass);
      }).error(function(response) {
        console.log(response);
      });
    }

    $scope.highlight = function($event) {
      $("ul.form_password li").removeClass('selected');
      $($event.currentTarget).addClass('selected');
      $scope.image_id = $($event.currentTarget).find("#image_id").val();
    }

    $scope.validatePassword = function () {
      console.log($scope.imagePass);
      loginAPIService.validatePassword($scope.id, $scope.image_id).success(function(response) {
        console.log(response);
        if(response.status == 200) {
          $("#response").val(response.data);
          $("#passwordForm").submit();
        } else if(response.status == 202) {
          if(response.data.message == "Account Locked") {
            // $("#passwordForm").prop('action', '/student/login');
            // $("#response").val("locked");
            // $("#passwordForm").submit();
            $scope.locked = true;
          } else {
            $scope.error = "Password does not match.";
          } 
        }
      }).error(function(response) {
        console.log(response);
      });
    }

    $scope.forgotPassword = function(username) {
      $scope.username = angular.copy(username);
      loginAPIService.forgotPassword($scope.username).success(function(response) {
        console.log(response);
        // window.location.href="/student/login/forgot-password-success";
      }).error(function(response) {
        console.log(response);
      });
    }

    $scope.validateCode = function(code, email) {
      $scope.code = angular.copy(code);
      $scope.email = angular.copy(email);

      console.log($scope.code);
      console.log($scope.email);

      // loginAPIService.validateCode($scope.code, $scope.email).success(function() {
      //   console.log(response);
      // }).error(function() {
      //   console.log(response);
      // });
    }

    $scope.validateRegistration = function(registration) {
      console.log(registration);
    }
});
   