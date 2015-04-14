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
            $scope.error = response.data;
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

    $scope.highlight = function() {
      console.log($scope.imagePass);
    }

    $scope.validatePassword = function () {
      console.log($scope.imagePass);
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
   