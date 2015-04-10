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

  controllers.controller('loginController', function($scope, loginAPIService) {
    $scope.id = "";
    $scope.validateUser = function() {
      loginAPIService.validateUser($scope.id).success(function (response) {
          console.log("Success...");
          // if success go to enter password 
      }).error(function() {
          console.log("Error...");
          // display error
      });

      // console.log(loginAPIService2.validateUser());
    }    
});
   