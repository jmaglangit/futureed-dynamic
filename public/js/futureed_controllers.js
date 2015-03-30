angular.module('futureed.controllers', []).

  //DRIVERS CONTROLLER
  controller('driversController', function($scope, futureedAPIservice) {
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